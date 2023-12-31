<?php

namespace app\controllers;

use app\models\Account;
use app\models\Customer;
use app\models\Fund;
use app\models\Investment;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $investment = new Investment();
        $investment->scenario = Investment::SCENARIO_NEW_INVESTMENT;

        // In a real application then we would of course load the customer from an authentication system.
        $customer = Customer::findOne(1);

        if ($investment->load(Yii::$app->request->post()) && $investment->validate()) {
            $investment->save();
            return $this->render('investment-success', ['investment' => $investment]);
        }

        return $this->render(
            'index',
            [
                'investment' => $investment,
                'accounts' => Account::find()->where(['customer_id' => $customer->id])->all(),
                'funds' => Fund::find()->all()
            ]
        );
    }
}
