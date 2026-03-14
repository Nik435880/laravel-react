<?php

namespace App\Http\Requests;

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(User $user, Room $room): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'text' => 'nullable|string|min:1|',
            'images.*' => 'nullable|min:1|file|image|max:2048|',
        ];
    }
}
