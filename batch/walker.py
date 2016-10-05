import mysql.connector
from pytz import timezone
import datetime

import mysql_setting

class Dao:
    def __init__(self):
        self.con = mysql.connector.connect(
                host =  mysql_setting.host,
                db = mysql_setting.db,
                port = mysql_setting.port,
                user = mysql_setting.user,
                passwd = mysql_setting.passwd,
                charset = mysql_setting.charset
            )
        self.con.time_zone = "+09:00"

    def insert(self, sql, params = ()):
        cur = self.con.cursor()
        cur.execute(sql, params)
        self.con.commit()

    def select(self, sql, params = ()):
        cur = self.con.cursor()
        cur.execute(sql, params)
        return cur.fetchall()

    def get_first_tweetid_in_day(self, day):
        vars = (day.year, day.month, day.day - 1)
        print(vars)
        format ="%Y-%m-%d %H:%M:%S %z"
        from_date = datetime.datetime.strptime("%s-%s-%s 00:00:00 +0900" % vars, format ).astimezone(timezone('UTC'))
        to_date = datetime.datetime.strptime("%s-%s-%s 23:59:59 +0900" % vars, format ).astimezone(timezone('UTC'))
        result = self.select("select tweet_id, tweet from daily where date >= %s and date <= %s order by date limit 1", (from_date, to_date))
        if(len(result) == 0):
            return None
        return int(result[0][0])

    def get_last_tweetid(self):
        result = self.select("select tweet_id from daily order by date desc limit 1")
        if(len(result) == 0):
            return None
        return int(result[0][0])

    def get_oldest_tweetid(self):
        result = self.select("select tweet_id from daily order by date limit 1")
        if len(result) == 0:
            return None
        return int(result[0][0])