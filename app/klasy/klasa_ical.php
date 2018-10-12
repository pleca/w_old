<?php

class ical
{

    protected $calendarName;
    protected $events = array();

    public function __construct($calendarName = "")
    {
        $this->calendarName = $calendarName;
    }

    public function addEvent($start, $end, $summary = '', $description = '', $url = '', $uid = '')
    {
        if (empty($uid)) {
            $uid = md5(uniqid(mt_rand(), true)) . '#38hCoF@=eQ4!scETVjA88u?sWE]WdsY';
        }
        $event = array(
            'start' => gmdate('Ymd', $start) . 'T' . gmdate('His', $start) . 'Z',
            'end' => gmdate('Ymd', $end) . 'T' . gmdate('His', $end) . 'Z',
            'summary' => $summary,
            'description' => $description,
            'url' => $url,
            'uid' => $uid
        );
        $this->events[] = $event;
        return $event;
    }

    public function getEvents(){
        return $this->events;
    }

    public function clearEvents()
    {
        $this->events = array();
    }

    public function getName()
    {
        return $this->calendarName;
    }

    public function setName($name)
    {
        $this->calendarName = $name;
    }

    public function render($output = true)
    {
        //Add header
        $ics = 'BEGIN:VCALENDAR
				METHOD:PUBLISH
				VERSION:2.0
				X-WR-CALNAME:' . $this->calendarName . '
				PRODID:-//hacksw/handcal//NONSGML v1.0//EN';

        //Add events
        foreach ($this->events as $event) {
            $ics .= '
					BEGIN:VEVENT
					UID:' . $event['uid'] . '
					DTSTAMP:' . gmdate('Ymd') . 'T' . gmdate('His') . 'Z
					DTSTART:' . $event['start'] . '
					DTEND:' . $event['end'] . '
					SUMMARY:' . str_replace("\n", "\\n", $event['summary']) . '
					DESCRIPTION:' . str_replace("\n", "\\n", $event['description']) . '
					URL;VALUE=URI:' . $event['url'] . '
					END:VEVENT';
        }

        //Add footer
        $ics .= '
				END:VCALENDAR';

        if ($output) {
            //Output
            $filename = $this->calendarName;
            //Filename needs quoting if it contains spaces
            if (strpos($filename, ' ') !== false) {
                $filename = '"'.$filename.'"';
            }
            header('Content-type: text/calendar; charset=utf-8');
            header('Content-Disposition: inline; filename=' . $filename . '.ics');
            echo $ics;
        }
        return $ics;
    }
}
