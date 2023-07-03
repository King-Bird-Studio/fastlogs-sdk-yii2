<?php

namespace fastlogsYii;

use fastlogs\sdk\Sender;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\log\Logger;
use yii\log\Target;
use yii\web\Request;
use yii\web\User;


class FastlogsTarget extends Target
{
    /**
     * @var string
     */
    public $slug;

    /**
     * @var Sender
     */
    public $sender;

    public function __construct($config = [])
    {
        parent::__construct($config);

        if (!$this->slug){
            throw new \Exception("Required parameter not specified slug");
        }

        $this->sender = new Sender($this->slug);
    }

    protected function getContextMessage()
    {
        return '';
    }

    public function export()
    {

        foreach ($this->messages as $message) {
            [$text, $level, $category] = $message;

            if ($text instanceof \Exception || $text instanceof \Throwable) {
                $text = (string) $text;
            } else {
                $text = VarDumper::export($text);
            }

            $data = [
                'message' => '',
                'level' => $this->getLogLevel($level),
                'tags' => ['category' => $category],
                'extra' => [],
                'userData' => [],
            ];

            $request = Yii::$app->getRequest();
            if ($request instanceof Request && $request->getUserIP()) {
                $data['userData']['ip_address'] = $request->getUserIP();
            }

            try {
                /** @var User $user */
                $user = Yii::$app->has('user', true) ? Yii::$app->get('user', false) : null;
                if ($user && ($identity = $user->getIdentity(false))) {
                    $data['userData']['id'] = $identity->getId();
                }
            } catch (\Throwable $e) {}

            if (is_array($text)) {
                if (isset($text['msg'])) {
                    $data['message'] = (string)$text['msg'];
                    unset($text['msg']);
                }
                if (isset($text['message'])) {
                    $data['message'] = (string)$text['message'];
                    unset($text['message']);
                }

                if (isset($text['tags'])) {
                    $data['tags'] = ArrayHelper::merge($data['tags'], $text['tags']);
                    unset($text['tags']);
                }

                if (isset($text['exception']) && $text['exception'] instanceof \Throwable) {
                    $data['exception'] = $text['exception'];
                    unset($text['exception']);
                }

                $data['extra'] = $text;
            } else {
                $data['message'] = $text;
            }

            try {
                $this->sender->add($data);
            }catch (\Exception $e){

            }
        }
    }

    protected function getLogLevel($level): string
    {
        switch ($level) {
            case Logger::LEVEL_PROFILE:
            case Logger::LEVEL_PROFILE_BEGIN:
            case Logger::LEVEL_PROFILE_END:
            case Logger::LEVEL_TRACE:
                return 'debug';
            case Logger::LEVEL_WARNING:
                return 'warning';
            case Logger::LEVEL_ERROR:
                return 'error';
            case Logger::LEVEL_INFO:
            default:
                return 'info';
        }
    }
}
