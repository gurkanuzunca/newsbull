<?php


class Date
{

    private $timezone;
    private $date;
    private $diff;
    private $month = array(1 => 'Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık');
    private $day = array(1 => 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar');


    public function __construct()
    {
        // Zaman ayarlaması yapılır
        $this->timezone = new DateTimeZone('Europe/Istanbul');
    }

    /**
     * Timestamp yada normal tarih tanımlar
     * Unix timestamp için @ kullanılır
     *
     * @param string $datetime
     * @return \Date
     */
    public function set($datetime = 'now')
    {
        $this->date = new DateTime($datetime, $this->timezone);
        $this->date->setTimezone($this->timezone);
        return $this;
    }


    public function diff($datetime)
    {
        $diff = new DateTime($datetime, $this->timezone);
        $this->diff = $this->date->diff($diff);
        $this->date = $diff;

        return $this;
    }

    public function diffWithDetail()
    {
        if ($this->diff->d < 4) {
            if ($this->diff->d > 0) {
                $string = $this->diff->d . ' gün önce';
            } elseif ($this->diff->h > 0) {
                $string = $this->diff->h . ' saat önce';
            } elseif ($this->diff->i > 0) {
                $string = $this->diff->i . ' dakika önce';
            } else {
                $string = $this->diff->s . ' saniye önce';
            }
        } else {
            $string = $this->datetimeWithName();
        }

        return $string;
    }


    public function diffDay()
    {
        return $this->diff->d;
    }


    public function diffHour()
    {
        return $this->diff->h;
    }

    public function diffSecond()
    {
        return $this->diff->s;
    }

    public function diffInvert()
    {
        return $this->diff->invert;
    }


    public function day()
    {
        return $this->date->format('d');
    }

    public function month()
    {
        return $this->date->format('m');
    }

    public function monthName()
    {
        return $this->month[$this->date->format('n')];
    }

    public function year()
    {
        return $this->date->format('Y');
    }

    /**
     * GG-AA-YYYY şeklinde tarihi formatlar
     *
     * @param string $separator
     * @return string
     */
    public function date($separator = '-')
    {
        $format = 'd' . $separator . 'm' . $separator . 'Y';
        return $this->date->format($format);
    }

    /**
     * GG Ay YYYY şeklinde tarihi formatlar
     *
     * @param string $separator
     * @return string
     */
    public function dateWithName($separator = ' ')
    {
        return $this->date->format('d') . $separator . $this->month[$this->date->format('n')] . $separator . $this->date->format('Y');
    }

    /**
     * SS:DD[:SS] şekinde saati formatlar
     *
     * @param bool $second
     * @param string $separator
     * @return string
     */
    public function time($second = false, $separator = ':')
    {
        $format = 'H' . $separator . 'i';

        if ($second === true) {
            $format = $format . $separator . 's';
        }
        return $this->date->format($format);
    }

    /**
     * GG-AA-YYYY SS:DD[:SS] şeklinde tarihi ve saati formatlar
     *
     * @param bool $second
     * @param string $datesap
     * @param string $timesap
     * @return string
     */
    public function datetime($second = false, $datesap = '-', $timesap = ':')
    {
        $format = 'd' . $datesap . 'm' . $datesap . 'Y H' . $timesap . 'i';

        if ($second === true) {
            $format = $format . $timesap . 's';
        }
        return $this->date->format($format);
    }

    /**
     * GG Ay YYYY SS:DD[:SS] şeklinde tarihi ve saati foratlar
     *
     * @param bool $second
     * @param string $datesap
     * @param string $timesap
     * @return string
     */
    public function datetimeWithName($second = false, $datesap = ' ', $timesap = ':')
    {
        $date = $this->date->format('d') . $datesap . $this->month[$this->date->format('n')] . $datesap . $this->date->format('Y');

        $format = 'H' . $timesap . 'i';

        if ($second === true) {
            $format = $format . $timesap . 's';
        }
        $time = $this->date->format($format);

        return $date . ' ' . $time;
    }

    /**
     * @return string
     */
    public function mysqlDate()
    {
        return $this->date->format('Y-m-d');
    }

    /**
     * @return string
     */
    public function mysqlDatetime()
    {
        return $this->date->format('Y-m-d H:i:s');
    }

    /**
     * Geçerli zamanın Timestamp halini döndürür
     *
     * @return int
     */
    public function timestamp()
    {
        return $this->date->getTimestamp();
    }

    /**
     * Zamanı istenlen biçimde formatlar
     *
     * @param string $format
     * @return string
     */
    public function format($format)
    {
        return $this->date->format($format);
    }

}

