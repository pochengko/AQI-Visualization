# -*- coding: utf-8 -*-
import urllib.request
import MySQLdb as mysql
import json
import os,time,requests,sys,datetime

conn=mysql.connect(host="localhost",user="user",passwd="pass",db="db",charset="utf8")
cursor=conn.cursor()

html = "https://data.lass-net.org/data/last-all-airbox.json"
htmltext = urllib.request.urlopen(html)
data = htmltext.read()

try:
    decoded = json.loads(data.decode('utf-8'))

    for i in range(0, len(decoded['feeds'])):
        device_id = decoded['feeds'][i]['device_id']
        area = decoded['feeds'][i]['area']
        lat = decoded['feeds'][i]['gps_lat']
        lon = decoded['feeds'][i]['gps_lon']
        pm25 = decoded['feeds'][i]['s_d0']
        hum = decoded['feeds'][i]['s_h0']
        temp = decoded['feeds'][i]['s_t0']
        timestamp = decoded['feeds'][i]['timestamp']
        timestamp = timestamp.replace("T"," ")
        timestamp = timestamp.replace("Z","")
        time = datetime.datetime.strptime(timestamp,'%Y-%m-%d %H:%M:%S')
        t = time + datetime.timedelta(hours=8)

        #print (device_id, pm25, t)
        select_sql = "SELECT * FROM iis_airbox WHERE t='%s' AND device_id='%s'" % (t,device_id)
        #print (select_sql)
        cursor.execute(select_sql)
        result=cursor.fetchall()
        if result==():
            cursor.execute("INSERT INTO iis_airbox(id,device_id,PM25,t) VALUES (null,%s,%s,%s)", (device_id,pm25,t,))
            cursor.execute("UPDATE iis_airbox_rt SET PM25=%s,t=%s WHERE device_id=%s", (pm25,t,device_id))
            cursor.execute("UPDATE iis_airbox_station SET status=%s WHERE device_id=%s", ("1",device_id))
            conn.commit()
        else:
            conn.close()
    print (len(decoded['feeds']))
except (ValueError, KeyError, TypeError):
    print ("JSON format error")
