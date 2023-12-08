import serial
import mysql.connector

try:
    serial_port = serial.Serial("/dev/ttyAMA0", 9600)
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


temporary_temperature = None
temporary_airPress = None


while True:
    try:
        serial_data = serial_port.read(25)
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

            print("Valuelist: " + str(value_list))
            if temporary_temp is not None and temporary_airPress is not None:
                temp = temporary_temp.replace("a", "")
                humidity = temporary_humidity.replace("b", "")
                airPress = temporary_airPress.replace("c", "")
                temporary_temp = None
                temporary_humidity = None
                temporary_airPress = None
                print("Temp: " + temp)
                print("Humidity: " + humidity)
                print("Airpress: " + airPress)
                try:
                    cursor.execute("INSERT INTO weerstation (temp, airPress, humidity) VALUES (%s, %s, %s)",
                                   (temp, airPress, humidity))
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
