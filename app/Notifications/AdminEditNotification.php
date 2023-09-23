<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminEditNotification extends Notification implements ShouldQueue
{
	use Queueable;

	private $login, $password;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct($admin)
	{
		$this->login = $admin->login;
		$this->password = $admin->originPassword;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return ['mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		return (new MailMessage)
			->subject('Ваши данные изменены')
			->greeting('Оповещение!')
			->line('Ваши данные администратора на сайте ' . config('app.name') . ' были изменены:')
			->line('Данные для входа в админ панель:')
			->line('Логин: '.$this->login)
			->line('Пароль: '.($this->password ?? 'Старый пароль' ));
	}
}
