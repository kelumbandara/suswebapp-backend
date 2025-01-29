<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Repositories\All\User\UserInterface;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    protected $userInterface;

    /**
     * Constructor injection of UserInterface.
     *
     * @param UserInterface $userInterface
     */
    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function store(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['isCompanyEmployee'] = (bool) $validatedData['isCompanyEmployee'];

        $user = $this->userInterface->create($validatedData);

        return response()->json([
            'message' => 'User registered successfully!',
            'user' => $user,
        ], 201);
    }

    public function index()
    {
        $user = $this->userInterface->All();

        return response()->json([
            'user' => $user,
        ], 201);
    }

}
