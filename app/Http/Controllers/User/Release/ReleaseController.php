<?php

namespace App\Http\Controllers\User\Release;

use App\Admin\Http\Requests\Auth\LoginRequest;
use App\Admin\Repositories\Question\QuestionRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Admin\Repositories\Slider\SliderRepositoryInterface;
use App\Enums\User\DatingTime;
use App\Enums\User\LookingFor;
use App\Enums\User\Relationship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReleaseController extends Controller
{
    private $login;

    protected SettingRepositoryInterface $settingRepository;
    protected SliderRepositoryInterface $sliderRepository;
    public function __construct(
        SettingRepositoryInterface $settingRepository,
        SliderRepositoryInterface $sliderRepository,
        protected QuestionRepositoryInterface $questionRepository,
    ) {
        parent::__construct();
        $this->settingRepository = $settingRepository;
        $this->sliderRepository = $sliderRepository;
    }
    public function getView()
    {
        return [
            'index' => 'user.release.index',
            'login' => 'user.release.login',
            'register' => 'user.release.register',
            'download' => 'user.release.app',
        ];
    }

    public function index()
    {
        $settings = $this->settingRepository->getAll();

        return view(
            $this->view['index'],
            [
                'settings' => $settings,
            ]
        );
    }

    public function login()
    {
        $settings = $this->settingRepository->getAll();
        return view($this->view['login'], [
            'settings' => $settings,
        ]);
    }

    public function register()
    {
        $settings = $this->settingRepository->getAll();

        return view($this->view['register'], [
            'settings' => $settings,
        ]);
    }

    public function download()
    {
        $requiredQuestion = $this->questionRepository->getRequiredWithRelation();
        $allQuestion = $this->questionRepository->getAllWithRelation();

        $settings = $this->settingRepository->getAll();
        return view($this->view['download'], [
            'settings' => $settings,
            'lookingFor' => LookingFor::asSelectArray(),
            'relationships' => Relationship::asSelectArray(),
            'datingTime' => DatingTime::asSelectArray(),
            'requiredQuestion' => $requiredQuestion,
            'allQuestion' => $allQuestion,
        ]);
    }
}
