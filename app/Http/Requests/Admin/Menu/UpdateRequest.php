<?php

namespace App\Http\Requests\Admin\Menu;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return auth('admin')->check();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' => ['nullable', 'string', 'min:3'],
			'post' => ['nullable', 'string', 'min:3'],
			'image' => ['nullable', 'image', 'max:2000'],
			'image_remove' => ['nullable'],
			'email' => ['required', 'email', 'unique:admins,email,' . $this->admin->id],
			'login' => ['required', 'string', 'min:3', 'unique:admins,login,' . $this->admin->id],
			'password_random' => ['nullable'],
			'password_change' => ['nullable'],
			'role' => ['required', 'integer', 'exists:roles,id'],
			'password' => [Rule::requiredIf(fn () => $this->has('password_change') && !$this->get('password_random')), 'min:3'],
		];
	}
}