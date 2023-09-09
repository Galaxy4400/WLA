<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;

class LoginRegisteredUser
{
	/**
	 * Handle the event.
	 *
	 * @param  object  $event
	 * @return void
	 */
	public function handle(Registered $event)
	{
		auth('web')->login($event->user);
	}
}
