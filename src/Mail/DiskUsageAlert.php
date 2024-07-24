<?php

namespace Donald1597\DiskUsage\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DiskUsageAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $usedPercentage;
    public $usedDiskSpace;

    /**
     * Create a new message instance.
     *
     * @param float $usedPercentage
     * @param string $usedDiskSpace
     */
    public function __construct($usedPercentage, $usedDiskSpace)
    {
        $this->usedPercentage = $usedPercentage;
        $this->usedDiskSpace = $usedDiskSpace;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('disk-usage::emails.disk_usage_alert')
            ->subject('Disk Usage Alert');
    }
}
