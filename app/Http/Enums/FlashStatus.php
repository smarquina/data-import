<?php

namespace App\Http\Enums;


class FlashStatus extends Enum {
    const SUCCESS = "status";
    const INFO    = "statusInfo";
    const WARNING = "statusWarning";
    const ERROR   = "statusError";
}
