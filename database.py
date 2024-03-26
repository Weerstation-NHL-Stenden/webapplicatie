import serial
import mysql.connector

os.system("sudo rfcomm bind 7 00:14:02:13:10:96")

try:
    serial_port = serial.Serial("/dev/rfcomm7", 9600)
except serial.SerialException as e:
    print("Fout bij het openen van de seriële poort:", e)
    exit()

try:
    sql_conn = mysql.connector.connect(user='weerstation', password='Kjeltmeteent',
                          host='localhost',
                          database='weerstation')
except mysql.connector.Error as err:
    print("Fout bij het openen van de MySQL-verbinding:", err)
    exit()

cursor = sql_conn.cursor()


temporary_temp = None
temporary_humidity = None
temporary_airPress = None
temporary_light = None
temporary_winddirection = None
temporary_windspeed = None
temporary_rain = None
temporary_uv = None
temporary_co2 = None


while True:
    try:
        serial_data = serial_port.read(100)
        if serial_data:
            value = serial_data.decode("utf-8")
            serial_port.reset_input_buffer()
            print("Value: " + value)
            value.replace(" ", "")
            value_list = value.split("|")
            for item in value_list:
                if item.count("a") == 2:
                    temporary_temp = item
                    print("temporary temp: " + temporary_temp)
                if item.count("b") == 2:
                    temporary_humidity = item
                    print("temporary humidity: " + temporary_humidity)
                if item.count("c") == 2:
                    temporary_airPress = item
                    print("temporary airPress: " + temporary_airPress)
                if item.count("d") == 2:
                    temporary_light = item
                    print("temporary light: " + temporary_light)
                if item.count("e") == 2:
                    temporary_winddirection = item
                    print("temporary winddirection: " + temporary_winddirection)
                if item.count("f") == 2:
                    temporary_windspeed = item
                    print("temporary windspeed: " + temporary_windspeed)
                if item.count("g") == 2:
                    temporary_rain = item
                    print("temporary rain: " + temporary_rain)
                if item.count("h") == 2:
                    temporary_uv = item
                    print("temporary uv: " + temporary_uv)
                if item.count("i") == 2:
                    temporary_co2 = item
                    print("temporary co2: " + temporary_co2)

            print("Valuelist: " + str(value_list))
            if temporary_temp is not None and temporary_airPress is not None and temporary_co2 is not None and temporary_humidity is not None and temporary_light is not None and temporary_winddirection is not None and temporary_windspeed is not None and temporary_rain is not None and temporary_uv is not None:
                temp = temporary_temp.replace("a", "")
                humidity = temporary_humidity.replace("b", "")
                airPress = temporary_airPress.replace("c", "")
                light = temporary_light.replace("d", "")
                winddirection = temporary_winddirection.replace("e", "")
                windspeed = temporary_windspeed.replace("f", "")
                rain = temporary_rain.replace("g", "")
                uv = temporary_uv.replace("h", "")
                co2 = temporary_co2.replace("i", "")
                temporary_temp = None
                temporary_humidity = None
                temporary_airPress = None
                temporary_light = None
                temporary_winddirection = None
                temporary_windspeed = None
                temporary_rain = None
                temporary_uv = None
                temporary_co2 = None
                print("Temp: " + temp)
                print("Humidity: " + humidity)
                print("Airpress: " + airPress)
                print("CO2: " + co2)
                try:
                    cursor.execute("INSERT INTO weerstation (temp, airPress, humidity, light, winddirection, windspeed, rain, uv, co2) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                                   (temp, airPress, humidity, light, winddirection, windspeed, rain, uv, co2))
                    sql_conn.commit()
                except mysql.connector.Error as err:
                    print("MySQL Error:", err)
            else:
                continue

    except KeyboardInterrupt:
        break

cursor.close()
sql_conn.close()
serial_port.close()
