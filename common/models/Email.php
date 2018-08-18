<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\bootstrap\Modal;

/**
 * This is the model class for table "email".
 *
 * @property string $id
 * @property string $recipient
 * @property string $cc
 * @property string $bcc
 * @property string $sender
 * @property string $name
 * @property string $subject
 * @property string $body
 * @property string $layout_html
 * @property string $date_created
 */
class Email extends Model
{

    public $to;
    public $cc;
    public $bcc;
    public $from;
    public $name; # from name
    public $subject;
    public $body;

    public $layout_html; # default: html
    public $layout_text; # default: text

    const SCENARIO_DB_SAVE = 'SCENARIO_DB_SAVE';
    const SCENARIO_DEFAULT = 'SCENARIO_DEFAULT';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    #'recipient', 
                    #'cc', 
                    #'bcc', 
                    'sender', 
                    'name', 
                    'subject', 
                    'body'
                ], 
                'string'
            ],
            [
                [
                    'recipient', 
                    #'cc', 
                    #'bcc', 
                    'sender', 
                    'name', 
                    'subject', 
                    'body'
                ], 
                'required'
            ],

            /*
            [
                [
                    'recipient', 
                    #'cc', 
                    #'bcc', 
                    'sender', 
                    'name', 
                    'subject', 
                    'body'
                ],
                'required',
                'message' => 'This field is required.',
                'on' => self::SCENARIO_DB_SAVE
            ],
            */

            [
                [
                    'recipient',
                    'cc',
                    'bcc',
                    'sender',
                    'name',
                    'subject',
                    'body',
                    'layout_html',
                    'is_sent',
                    'date_lock',
                    'date_created'
                ], 
                'safe'
            ],
            [
                [
                    'layout_html'
                ], 
                'string', 
                'max' => 50
            ],
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail(){
        libxml_use_internal_errors(true);

        $bcc         = is_array($this->bcc) ? implode(',', $this->bcc) : $this->bcc; # bcc must surely be an array
        $cc          = is_array($this->cc) ? implode(',', $this->cc) : $this->cc;  # cc must surely be an array
        $recipient   = is_array($this->to) ? implode(',', $this->to) : $this->to;# recipient must surely be an array
        $layout_html = !empty($this->layout_html) ? $this->layout_html : 'html';
        $name        = $this->name;
        $body        = $this->body;
        $sender      = $this->from;;
        $subject     = $this->subject;

        # Note: fetch values from database entry; no longer a direct user input
        $result = Yii::$app->mail->compose(!empty($layout_html) ? $layout_html : 'html', # 'html' is the default value
            [
                'content' => $body
            ]
        )
            ->setFrom([$sender => $name])
            ->setTo($recipient)
            ->setCc($cc)
            ->setBcc($bcc)
            ->setSubject($subject)
            ->send()
        ;

        return $result ? true : false;
    }

}
