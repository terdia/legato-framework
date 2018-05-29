<?php

namespace Legato\Framework\Profiler;

use Symfony\Component\Stopwatch\Stopwatch;

class Profiler extends Stopwatch
{
    /**
     * Profiler Event Handler.
     *
     * @var
     */
    protected $event;

    /**
     * Stop the event and set the event handler.
     *
     * @param string $name
     *
     * @return \Symfony\Component\Stopwatch\StopwatchEvent
     */
    public function stop($name)
    {
        return $this->event = parent::stop($name);
    }

    /**
     * Convert start time to datetime from milliseconds.
     *
     * @return false|null|string
     */
    public function whenStarted()
    {
        $milliseconds = $this->event->getOrigin();
        $seconds = $milliseconds / 1000;

        return is_float($seconds) ? date('Y-m-d H:i:s', $seconds) : null;
    }

    /**
     * returns the event duration, including all periods.
     *
     * @return mixed
     */
    public function eventDuration()
    {
        return $this->event->getDuration();
    }

    /**
     * the category the event was started in.
     *
     * @return mixed
     */
    public function eventCategory()
    {
        return $this->event->getCategory();
    }

    /**
     * the start time of the very first period.
     *
     * @return mixed
     */
    public function firstPeriodEndTime()
    {
        return $this->event->getStartTime();
    }

    /**
     * the end time of the very last period.
     *
     * @return mixed
     */
    public function lastPeriodEndTime()
    {
        return $this->event->getEndTime();
    }

    /**
     * the max memory usage of all periods
     * The memory usage (in bytes).
     *
     * @return mixed
     */
    public function eventMemoryUsage()
    {
        return $this->event->getMemory();
    }

    public function eventPeriods()
    {
        return $this->event->getPeriods();
    }

    /**
     * stops all periods not already stopped.
     *
     * @return mixed
     */
    public function forceStop()
    {
        return $this->event->ensureStopped();
    }

    /**
     * Stop a session and return the event data.
     *
     * @param $name
     *
     * @return \Symfony\Component\Stopwatch\StopwatchEvent[]
     */
    public function sectionStop($name)
    {
        $this->stopSection($name);

        return $this->getSectionEvents($name);
    }
}
