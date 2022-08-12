<?php
namespace App\Enum;

interface JobApplicationInterviewStatus
{
    const STARTED = 'started';
    const NOT_STARTED = 'notstarted';
    const FAIL = 'fail';
    const PASS = 'pass';
}
