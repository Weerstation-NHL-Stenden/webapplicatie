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
        serial_data = serial_port.read(4)
        if serial_data:
            value = serial_data.decode()
            value = value[:4]

            try:
                cursor.execute("INSERT INTO weerstation (temp) VALUES (%s)", (value,))
                sql_conn.commit()
            except mysql.connector.Error as err:
                print("MySQL Error:", err)

    except KeyboardInterrupt:
        break

cursor.close()
sql_conn.close()
serial_port.close()



