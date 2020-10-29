from selenium import webdriver
from selenium.webdriver.chrome.options import Options
import webdriver_manager
from webdriver_manager.chrome import ChromeDriverManager
from bs4 import BeautifulSoup
import time
import pymysql

options = Options()
options.add_argument("--disable-notifications")
options.add_argument('--headless')
options.add_argument('--no-sandbox')

#chrome = webdriver.Chrome(ChromeDriverManager().install(), chrome_options=options)
chrome = webdriver.Chrome('/usr/lib/chromium-browser/chromedriver', chrome_options=options)
chrome.get("https://nidss.cdc.gov.tw/en/Rods/Rods02?disease=4")

print(chrome.current_url)

submit = chrome.find_element_by_class_name("highcharts-button-symbol")
submit.click()

submit2 = chrome.find_elements_by_class_name("highcharts-menu-item")[-1]
chrome.execute_script("arguments[0].click();", submit2)

soup = BeautifulSoup(chrome.page_source, 'lxml')

tbody = soup.find_all('table', id='highcharts-data-table-0')[0].find_all('tbody')

period = tbody[0].find_all('tr')[-2].find_all('th')[0].text
nationwide = tbody[0].find_all('tr')[-2].find_all('td')[0].text
taipei = tbody[0].find_all('tr')[-2].find_all('td')[1].text
northern = tbody[0].find_all('tr')[-2].find_all('td')[2].text
central = tbody[0].find_all('tr')[-2].find_all('td')[3].text
southern = tbody[0].find_all('tr')[-2].find_all('td')[4].text
kaoping = tbody[0].find_all('tr')[-2].find_all('td')[5].text
eastern = tbody[0].find_all('tr')[-2].find_all('td')[6].text


for i in range(0,7):
    tds = tbody[0].find_all('tr')[-2].find_all('td')[i].text




date = soup.find('td', {'align': 'left'})

updateTime = date.find_all('li')[0].text
year = date.find_all('li')[1].string[32:36]
week = date.find_all('li')[1].string[28:30]
period = year + week

print(updateTime)
print(period, year, week, nationwide, taipei, northern, central, southern, kaoping, eastern)
print(tds)
chrome.quit()

db_settings = {
    "host": "localhost",
    "port": 3306,
    "user": "admin",
    "password": "1j6el4nj4su3",
    "db": "Environment",
    "charset": "utf8"
}

try:
    conn = pymysql.connect(**db_settings)

    with conn.cursor() as cursor:
        sql = """INSERT INTO ili(
                        period,
                        year,
                        week,
                        nationwide,
                        taipei,
                        northern,
                        central,
                        southern,
                        kaoping,
                        eastern)
                VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"""
        data = (period, year, week, nationwide, taipei, northern, central, southern, kaoping, eastern)

        cursor.execute(sql, data)
        conn.commit()

except Exception as ex:
    print("Exception:", ex)