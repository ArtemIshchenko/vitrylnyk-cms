<?php
namespace app\modules\feedback;

class Feedback extends \app\components\Module
{
    public $settings = [
        'mailAdminOnNewFeedback' => true,
        'subjectOnNewFeedback' => 'New feedback',
        'templateOnNewFeedback' => '@app/modules/feedback/mail/en/new_feedback',

        'answerTemplate' => '@app/modules/feedback/mail/en/answer',
        'answerSubject' => 'Answer on your feedback message',
        'answerHeader' => 'Hello,',
        'answerFooter' => 'Best regards.',

        'enableTitle' => false,
        'enablePhone' => true,
        'enableCaptcha' => false,
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Feedback',
            'ru' => 'Обратная связь',
						'uk' => 'Зворотній зв\'язок',
        ],
        'icon' => 'earphone',
        'pos' => 60,
    ];
}