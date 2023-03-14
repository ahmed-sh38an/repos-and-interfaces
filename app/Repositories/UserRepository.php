<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserInterface
{
  public function all()
  {
    return User::all();
  }

  public function show($id)
  {
    $user = User::where('id', $id)->first();

    return $user;
  }

  public function store($data)
  {
    $user = User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => bcrypt($data['password']),
    ]);
    return $user;
  }

  public function update($id, $data)
  {
    $user = User::where('id', $id)->first();
    return $user->update($data);
  }

  public function delete($id)
  {
    $user = User::where('id', $id)->first();

    $user->delete();
    return $user;
  }
}