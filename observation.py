# -*- coding: utf-8 -*-
import MySQLdb as mysql
import os,time,requests,sys,datetime
from bs4 import *
conn=mysql.connect(host="localhost",user="user",passwd="pass",db="db",charset="utf8")
cursor=conn.cursor()

def is_number(s):
    try:
        float(s)
        return s
    except ValueError:
        pass

    try:
        import unicodedata
        unicodedata.numeric(s)
        return s
    except (TypeError, ValueError):
        pass
    s='NA'
    return s

url_Time='http://taqm.epb.taichung.gov.tw/TQAMNEWAQITABLE.ASPX'

url_Observation='http://taqm.epb.taichung.gov.tw/aqi/aqiNEW.ASPX?name=14'
html=requests.get(url_Observation)
html.encoding='utf-8'
sp=BeautifulSoup(html.text,'html.parser')

html2=requests.get(url_Time)
html2.encoding='utf-8'
sp2=BeautifulSoup(html2.text,'html.parser')
#print (sp2.find_all('span')[1])
Year=sp2.find('span', id='Label2').string[16:20]
Mon=sp2.find('span', id='Label2').string[21:23]
Day=sp2.find('span', id='Label2').string[24:26]
Hour=sp2.find('span', id='Label2').string[28:30]


PM10 = sp.find_all('td')[14].string
PM10 = is_number(PM10)
PM25 = sp.find_all('td')[18].string
PM25 = is_number(PM25)

date=Year+"-"+Mon+"-"+Day+" "+Hour+":00"
#print(url_Observation)
# print (SiteName,County,AQI,Pollutant,Status,SO2,CO,CO_8hr,O3,O3_8hr,PM10,PM25,NO2,NOx,NO,WindSpeed,WindDirec,PublishTime,PM10_AVG,PM25_AVG)

cursor.execute("SET NAMES UTF8")
cursor.execute("SELECT * FROM thu WHERE timestamp = %s AND sensor='THUELE'", (date,))
result=cursor.fetchall()
conn.commit()

if result ==():
    cursor.execute("UPDATE thu SET temp=%s,hum=%s,PM25=%s,PM10=%s,timestamp=%s WHERE sensor='THUELE'", (null,null,PM25,PM10,date))
    conn.commit()
else:
    conn.close()
