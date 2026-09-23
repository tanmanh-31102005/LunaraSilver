<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\StoreAddressRequest;
use App\Http\Requests\Account\UpdateAddressRequest;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AddressController extends Controller
{
    public function index(Request $request): View
    {
        $addresses = $request->user()
            ->addresses()
            ->orderByDesc('is_default')
            ->orderByDesc('id')
            ->get();

        return view('account.addresses.index', compact('addresses'));
    }

    public function store(StoreAddressRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        DB::transaction(function () use ($user, $data): void {
            $isFirstAddress = $user->addresses()->count() === 0;
            $shouldBeDefault = $isFirstAddress || ! empty($data['is_default']);

            if ($shouldBeDefault) {
                $user->addresses()->update(['is_default' => false]);
            }

            $user->addresses()->create(array_merge($data, [
                'is_default' => $shouldBeDefault,
            ]));
        });

        return redirect()->route('account.addresses.index')
            ->with('success', 'Địa chỉ mới đã được lưu thành công.');
    }

    public function update(UpdateAddressRequest $request, Address $address): RedirectResponse
    {
        $user = $request->user();

        if ($address->user_id !== $user->id) {
            abort(403, 'Bạn không có quyền chỉnh sửa địa chỉ này.');
        }

        $data = $request->validated();

        DB::transaction(function () use ($user, $address, $data): void {
            $shouldBeDefault = ! empty($data['is_default']);

            if ($shouldBeDefault) {
                $user->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
            } elseif ($address->is_default && $user->addresses()->count() > 1) {
                // If user unchecks default on the current default address, promote another address
                $otherAddress = $user->addresses()->where('id', '!=', $address->id)->latest('id')->first();
                if ($otherAddress) {
                    $otherAddress->update(['is_default' => true]);
                }
            }

            $address->update($data);
        });

        return redirect()->route('account.addresses.index')
            ->with('success', 'Địa chỉ đã được cập nhật thành công.');
    }

    public function destroy(Request $request, Address $address): RedirectResponse
    {
        $user = $request->user();

        if ($address->user_id !== $user->id) {
            abort(403, 'Bạn không có quyền xóa địa chỉ này.');
        }

        DB::transaction(function () use ($user, $address): void {
            $wasDefault = $address->is_default;
            $address->delete();

            if ($wasDefault) {
                // Promote the latest remaining address to default
                $nextDefault = $user->addresses()->latest('id')->first();
                if ($nextDefault) {
                    $nextDefault->update(['is_default' => true]);
                }
            }
        });

        return redirect()->route('account.addresses.index')
            ->with('success', 'Địa chỉ đã được xóa thành công.');
    }

    public function setDefault(Request $request, Address $address): RedirectResponse
    {
        $user = $request->user();

        if ($address->user_id !== $user->id) {
            abort(403, 'Bạn không có quyền thao tác trên địa chỉ này.');
        }

        DB::transaction(function () use ($user, $address): void {
            $user->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
            $address->update(['is_default' => true]);
        });

        return redirect()->route('account.addresses.index')
            ->with('success', 'Đã đặt làm địa chỉ giao hàng mặc định.');
    }
}
