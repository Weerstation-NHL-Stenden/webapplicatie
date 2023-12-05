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

while True:
    try:
        serial_data = serial_port.read(20)
        if serial_data:
            value = serial_data.decode("utf-8")
            serial_port.reset_input_buffer()
            print("Value: " + value)
            value.replace(" ", "")
            value_list = value.split("|")
            print("Valuelist: " + str(value_list))
            temp = value_list[0]
            print("Temp: " + temp)
            humidity = value_list[1]
            print("Humidity: " + humidity)
            airPress = value_list[2]
            print("Airpress" + airPress)

            try:
                cursor.execute("INSERT INTO weerstation (temp, airPress, humidity) VALUES (%s, %s, %s)", (temp, airPress, humidity))
                sql_conn.commit()
            except mysql.connector.Error as err:
                print("MySQL Error:", err)

    except KeyboardInterrupt:
        break

cursor.close()
sql_conn.close()
serial_port.close()
