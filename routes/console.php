<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:escalate-overdue-invoices')->hourly()->timezone('Asia/Jakarta');
Schedule::command('app:send-invoice-reminders')->dailyAt('08:00')->timezone('Asia/Jakarta');
Schedule::command('app:low-stock-alert')->dailyAt('07:00')->timezone('Asia/Jakarta');
Schedule::command('app:backup-database')->dailyAt('02:00')->timezone('Asia/Jakarta');
Schedule::command('seo:indexnow')->dailyAt('02:45')->timezone('Asia/Jakarta');
