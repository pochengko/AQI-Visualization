# -*- coding: utf-8 -*-
import urllib3
import urllib
import MySQLdb as mysql
import pymysql
import json
import os,time,requests,sys,datetime
reload(sys)#重要編碼
from threading import Timer
from datetime import date, tzinfo, datetime
from dateutil import tz
from time import strftime, gmtime, localtime
from bs4 import *
#urllib3.disable_warnings()
sys.setdefaultencoding('utf8')

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
    s='0.00001'
    return s

htmltext = urllib.urlopen("https://opendata.epa.gov.tw/ws/Data/AQI/?$format=json")

try:
    decoded = json.load(htmltext)

    for i in range(0, len(decoded)):

        lat = decoded[i]['Latitude']
        lon = decoded[i]['Longitude']
        site_id = i
        pm10 = is_number(decoded[i]['PM10'])
        co = is_number(decoded[i]['CO'])
        o3 = is_number(decoded[i]['O3'])
        so2 = is_number(decoded[i]['SO2'])
        no = is_number(decoded[i]['NO'])
        no2 = is_number(decoded[i]['NO2'])
        nox = is_number(decoded[i]['NOx'])
        direc = is_number(decoded[i]['WindDirec'])
        speed = is_number(decoded[i]['WindSpeed'])
        SiteName = decoded[i]['SiteName']
        PublishTime = decoded[i]['PublishTime']

        if ((SiteName) == '林園'):
            site_id = 'EPA052'
        elif ((SiteName) == '基隆'):
            site_id = 'EPA001'
        elif ((SiteName) == '汐止'):
            site_id = 'EPA002'
        elif ((SiteName) == '萬里'):
            site_id = 'EPA003'
        elif ((SiteName) == '新店'):
            site_id = 'EPA004'
        elif ((SiteName) == '土城'):
            site_id = 'EPA005'
        elif ((SiteName) == '板橋'):
            site_id = 'EPA006'
        elif ((SiteName) == '新莊'):
            site_id = 'EPA007'
        elif ((SiteName) == '菜寮'):
            site_id = 'EPA008'
        elif ((SiteName) == '林口'):
            site_id = 'EPA009'
        elif ((SiteName) == '淡水'):
            site_id = 'EPA010'
        elif ((SiteName) == '士林'):
            site_id = 'EPA011'
        elif ((SiteName) == '中山'):
            site_id = 'EPA012'
        elif ((SiteName) == '萬華'):
            site_id = 'EPA013'
        elif ((SiteName) == '古亭'):
            site_id = 'EPA014'
        elif ((SiteName) == '松山'):
            site_id = 'EPA015'
        elif ((SiteName) == '桃園'):
            site_id = 'EPA017'
        elif ((SiteName) == '大園'):
            site_id = 'EPA018'
        elif ((SiteName) == '觀音'):
            site_id = 'EPA019'
        elif ((SiteName) == '平鎮'):
            site_id = 'EPA020'
        elif ((SiteName) == '龍潭'):
            site_id = 'EPA021'
        elif ((SiteName) == '湖口'):
            site_id = 'EPA022'
        elif ((SiteName) == '竹東'):
            site_id = 'EPA023'
        elif ((SiteName) == '新竹'):
            site_id = 'EPA024'
        elif ((SiteName) == '頭份'):
            site_id = 'EPA025'
        elif ((SiteName) == '苗栗'):
            site_id = 'EPA026'
        elif ((SiteName) == '三義'):
            site_id = 'EPA027'
        elif ((SiteName) == '豐原'):
            site_id = 'EPA028'
        elif ((SiteName) == '沙鹿'):
            site_id = 'EPA029'
        elif ((SiteName) == '大里'):
            site_id = 'EPA030'
        elif ((SiteName) == '忠明'):
            site_id = 'EPA031'
        elif ((SiteName) == '西屯'):
            site_id = 'EPA032'
        elif ((SiteName) == '彰化'):
            site_id = 'EPA033'
        elif ((SiteName) == '線西'):
            site_id = 'EPA034'
        elif ((SiteName) == '二林'):
            site_id = 'EPA035'
        elif ((SiteName) == '南投'):
            site_id = 'EPA036'
        elif ((SiteName) == '斗六'):
            site_id = 'EPA037'
        elif ((SiteName) == '崙背'):
            site_id = 'EPA038'
        elif ((SiteName) == '新港'):
            site_id = 'EPA039'
        elif ((SiteName) == '朴子'):
            site_id = 'EPA040'
        elif ((SiteName) == '臺西'):
            site_id = 'EPA041'
        elif ((SiteName) == '嘉義'):
            site_id = 'EPA042'
        elif ((SiteName) == '新營'):
            site_id = 'EPA043'
        elif ((SiteName) == '善化'):
            site_id = 'EPA044'
        elif ((SiteName) == '安南'):
            site_id = 'EPA045'
        elif ((SiteName) == '臺南'):
            site_id = 'EPA046'
        elif ((SiteName) == '美濃'):
            site_id = 'EPA047'
        elif ((SiteName) == '橋頭'):
            site_id = 'EPA048'
        elif ((SiteName) == '仁武'):
            site_id = 'EPA049'
        elif ((SiteName) == '鳳山'):
            site_id = 'EPA050'
        elif ((SiteName) == '大寮'):
            site_id = 'EPA051'
        elif ((SiteName) == '楠梓'):
            site_id = 'EPA053'
        elif ((SiteName) == '左營'):
            site_id = 'EPA054'
        elif ((SiteName) == '前金'):
            site_id = 'EPA056'
        elif ((SiteName) == '前鎮'):
            site_id = 'EPA057'
        elif ((SiteName) == '小港'):
            site_id = 'EPA058'
        elif ((SiteName) == '屏東'):
            site_id = 'EPA059'
        elif ((SiteName) == '潮州'):
            site_id = 'EPA060'
        elif ((SiteName) == '恆春'):
            site_id = 'EPA061'
        elif ((SiteName) == '臺東'):
            site_id = 'EPA062'
        elif ((SiteName) == '花蓮'):
            site_id = 'EPA063'
        elif ((SiteName) == '陽明'):
            site_id = 'EPA064'
        elif ((SiteName) == '宜蘭'):
            site_id = 'EPA065'
        elif ((SiteName) == '冬山'):
            site_id = 'EPA066'
        elif ((SiteName) == '三重'):
            site_id = 'EPA067'
        elif ((SiteName) == '中壢'):
            site_id = 'EPA068'
        elif ((SiteName) == '竹山'):
            site_id = 'EPA069'
        elif ((SiteName) == '永和'):
            site_id = 'EPA070'
        elif ((SiteName) == '復興'):
            site_id = 'EPA071'
        elif ((SiteName) == '埔里'):
            site_id = 'EPA072'
        elif ((SiteName) == '崇倫'):
            site_id = 'EPA074'
        elif ((SiteName) == '馬祖'):
            site_id = 'EPA075'
        elif ((SiteName) == '阿里山'):
            site_id = 'EPA076'
        elif ((SiteName) == '金門'):
            site_id = 'EPA077'
        elif ((SiteName) == '馬公'):
            site_id = 'EPA078'
        elif ((SiteName) == '關山'):
            site_id = 'EPA080'
        elif ((SiteName) == '泰山'):
            site_id = 'EPA081'

        print lat, lon, site_id, pm10, co, o3, so2, no, no2, nox, direc, speed, SiteName, PublishTime
        print i

        cursor.execute("SET NAMES UTF8")
        select_sql="select * from jrlin where `PublishTime`=%s and `site_id`= %s "
        cursor.execute(select_sql,(PublishTime,site_id,))
        result=cursor.fetchall()
        conn.commit()
        site_id = site_id
        if result==():
            insert_sql = "insert into jrlin(id,lat,lon,site_id,pm10,co,o3,so2,no,no2,nox,direc,speed,SiteName,PublishTime) values (null,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
            data = lat,lon,site_id,pm10,co,o3,so2,no,no2,nox,direc,speed,SiteName,PublishTime
            cursor.execute(insert_sql,data)
            cursor.execute("""
               UPDATE jrlin_rt
               SET pm10=%s,co=%s,o3=%s,so2=%s,no=%s,no2=%s,nox=%s,direc=%s,speed=%s,PublishTime=%s
               WHERE site_id=%s
            """, (pm10,co,o3,so2,no,no2,nox,direc,speed,PublishTime,site_id))
            conn.commit()
        else:
            conn.close()

    print len(decoded)

except (ValueError, KeyError, TypeError):
    print "JSON format error"
