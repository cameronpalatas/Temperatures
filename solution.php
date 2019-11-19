<?php

class Client {

    protected $maximum;
    protected $average;
    protected $historic_index = 0;
    protected $historic_log_data = [];

    public static $timeframe = 3;
    // public static $timeframe = (60 * 60) * 24; // Commented out for the purposes of testing.

    /**
     * This function instantiates our Client class with a fresh historic log data array at index 0.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->historic_log_data[$this->historic_index] = [
            'average' => 0,
            'temperatures' => [],
            'temperature_sums' => 0,
            'maximum' => 0,
        ];
    }

    /**
     * This function logs all relevant temperature information for the client.
     * 
     * @param int | float $temperature A temperature of type int or float.
     * @access public
     * @return void
     */
    public function log($temperature)
    {
        $total_temps_in_index = count($this->historic_log_data[$this->historic_index]['temperatures']) + 1;

        $this->historic_log_data[$this->historic_index]['temperatures'][] = $temperature;
        $this->historic_log_data[$this->historic_index]['temperature_sums'] += $temperature;
        $this->historic_log_data[$this->historic_index]['average'] = $total_temps_in_index === 1 ? $temperature : $this->historic_log_data[$this->historic_index]['temperature_sums'] / $total_temps_in_index;
        $this->historic_log_data[$this->historic_index]['maximum'] = $this->historic_log_data[$this->historic_index]['maximum'] < $temperature ? $temperature : $this->historic_log_data[$this->historic_index]['maximum'];

        $this->setAverage();
        $this->setMaximum();

        if($total_temps_in_index === self::$timeframe) {
            $this->setNewHistoricIndex();
        }
    }

    /**
     * This function increments our historic index and instantiates a new array at the new index.
     * 
     * @access private
     * @return void
     */
    private function setNewHistoricIndex()
    {
        $this->historic_index++;
        $this->historic_log_data[$this->historic_index] = [
            'average' => 0,
            'temperatures' => [],
            'temperature_sums' => 0,
            'maximum' => 0,
        ];
    }

    /**
     * This function updates the average value of our historic log data at index $this->historic_index.
     * 
     * @access private
     * @return void
     */
    private function setAverage()
    {
        $this->average = $this->historic_log_data[$this->historic_index]['average'];
    }

    /**
     * This function updates the maximum value of our historic log data at index $this->historic_index.
     * 
     * @access private
     * @return void
    */
    private function setMaximum()
    {
        $this->maximum = $this->historic_log_data[$this->historic_index]['maximum'];
    }

    /**
     * This function gets the maximum value of our historic log data at index $this->historic_index from $this->maximum.
     * 
     * @access public
     * @return void
     */
    public function getMaximum()
    {
        return (float) $this->maximum;
    }

    /**
     * This function gets the average value of our historic log data at index $this->historic_index from $this->average.
     * 
     * @access public
     * @return void
     */
    public function getAverage()
    {
        return (float) $this->average;
    }

}


$client = new Client();

$client->log(40);
var_dump([
    'maximum' => $client->getMaximum(), // Should equal 40
    'average' => $client->getAverage() // Should equal 40
]);


$client->log(40.0);
$client->log(50);
var_dump([
    'maximum' => $client->getMaximum(), // Should equal 50
    'average' => $client->getAverage() // Should equal 43.3 repeating
]);


$client->log(10);
var_dump([
    'maximum' => $client->getMaximum(), // Should equal 10
    'average' => $client->getAverage() // Should equal 10
]);


$client->log(20);
var_dump([
    'maximum' => $client->getMaximum(), // Should equal 20
    'average' => $client->getAverage() // Should equal 15
]);

