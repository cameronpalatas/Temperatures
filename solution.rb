class Client

    def initialize()

        @maximum = 0
        @average = 0
        @timeframe = 3
        @historic_index = 0

        @historic_log_data = [].push({
            :maximum => 0,
            :average => 0,
            :temperature_sums => 0,
            :temperatures => [],
        })

    end

    def historic_log_data
        @historic_log_data
    end

    def historic_index
        @historic_index
    end

    def average
        @average
        puts @average
    end

    def maximum
        @maximum
        puts @maximum
    end

    def timeframe
        @timeframe
    end

    def log(temperature)
        
        total_temps = historic_log_data[historic_index][:temperatures].count() + 1

        historic_log_data[historic_index][:temperatures].push(temperature)
        historic_log_data[historic_index][:temperature_sums] += temperature
        historic_log_data[historic_index][:average] = historic_log_data[historic_index][:temperature_sums] / total_temps
        historic_log_data[historic_index][:maximum] = historic_log_data[historic_index][:maximum] < temperature ? temperature : historic_log_data[historic_index][:maximum]

        setAverage()
        setMaximum()

        if(total_temps === timeframe)
            setNewHistoricIndex()
        end

    end

    def setNewHistoricIndex()
        @historic_index += 1
        @historic_log_data.push({
            :maximum => 0,
            :average => 0,
            :temperature_sums => 0,
            :temperatures => [],
        })
    end

    def setAverage()
        @average = historic_log_data[historic_index][:average]
    end

    def setMaximum()
        @maximum = historic_log_data[historic_index][:maximum]
    end

end

client = Client.new
client.log(50)
client.log(80.2)
client.log(20)

client.average
client.maximum

client.log(4)
client.average
client.maximum

