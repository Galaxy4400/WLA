<?php

namespace App\Http\Requests\Admin\MenuItem;

use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
			'menu_id' => ['required', 'integer'],
			'parent_id' => ['required', 'integer'],
			'type' => ['required', 'integer'],
			'name' => ['required', 'string', 'min:3'],
			'url' => ['required_if:type,' . MenuItem::TYPE_URL, 'url'],
			'route' => ['required_if:type,' . MenuItem::TYPE_ROUTE, 'string'],
			'page' => ['required_if:type,' . MenuItem::TYPE_PAGE, 'string'],
			'open_type' => ['required', 'integer'],
			'source' => ['required'],
		];
	}

	/**
	 * Prepare the data for validation.
	 *
	 * @return void
	 */
	protected function prepareForValidation()
	{
		$this->setMenuIdParameter();
		$this->setSourceParameter();
		$this->setNameParameter();
	}

	/**
	 * Determin menu_id to request
	 */
	public function setMenuIdParameter()
	{
		if ($this->menu->exists) {
			$this->merge(['menu_id' => $this->menu->id]);
		}
	}

	/**
	 * Determin source to request
	 */
	public function setSourceParameter()
	{
		if (isset($this->type)) {
			switch ($this->type) {
				case MenuItem::TYPE_URL: $this->merge(['source' => $this->url]); break;
				case MenuItem::TYPE_ROUTE: $this->merge(['source' => $this->route]); break;
				case MenuItem::TYPE_PAGE: $this->merge(['source' => $this->page]); break;
			}
		}
	}

	/**
	 * Determin name to request
	 */
	public function setNameParameter()
	{
		if (!$this->name) {
			switch ($this->type) {
				case MenuItem::TYPE_URL: $this->merge(['name' => 'Ссылка']); break;
				case MenuItem::TYPE_ROUTE: $this->merge(['name' => $this->route]); break;
				case MenuItem::TYPE_PAGE: $this->merge(['name' => Page::where('slug', $this->page)->first()->name]); break;
			}
		}
	}

}
