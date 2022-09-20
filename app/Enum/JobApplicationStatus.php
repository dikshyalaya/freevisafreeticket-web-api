<?php
namespace App\Enum;

interface JobApplicationStatus
{
    const PENDING = 'pending';
    const SORT_LISTED = 'sortlisted';
    const SELECTED_FOR_INTERVIEW = 'selectedForInterview';
    const INTERVIEWED = 'interviewed';
    const ACCEPTED = 'accepted';
    const REJECTED = 'rejected';
    const RED_LISTED = 'redlisted';
}
