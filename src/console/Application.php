<?php

namespace hyii\console;

use Hyii;
use hyii\base\ApplicationTrait;

class Application extends \yii\console\Application {

    use ApplicationTrait;

    public function __construct($config = [])
    {
        Hyii::$app = $this;
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function bootstrap()
    {
        // Ensure that the request component has been instantiated
        if (!$this->has('request', true)) {
            $this->getRequest();
        }

        parent::bootstrap();
    }


}