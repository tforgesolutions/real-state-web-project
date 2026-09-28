<?php
$u = \App\Models\User::where('email', 'admin@admin.com')->first();
if($u) {
    $u->password = \Illuminate\Support\Facades\Hash::make('password');
    $u->save();
    echo 'Password set to password';
} else {
    echo 'Not found';
}
