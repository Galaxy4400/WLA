<?php

namespace App\Jobs;

use App\Mail\ForgotMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ForgotPasswordJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $user, $password;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($user, $password)
	{
		$this->user = $user;
		$this->password = $password;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		Mail::to($this->user)->send(new ForgotMail($this->password));
	}
}
