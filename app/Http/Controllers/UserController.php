<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserInterface;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {

        return $this->userRepository->all();
    }

    public function show($id)
    {
        return $this->userRepository->show($id);
    }

    public function store(Request $request)
    {
        $data = $request->input();
        return $this->userRepository->store($data);
    }

    public function update($id, Request $request)
    {
        $data = $request->input();
        $data['password'] = bcrypt($data['password']);
        return $this->userRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->userRepository->delete($id);
    }
}