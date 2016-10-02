# -*- coding:UTF-8 -*-

from pytz import timezone
import tweepy
import datetime
import mysql.connector

from walker import Dao

import JST

import app_setting
import twitter_setting

if __name__ == '__main__':
    dao = Dao()
    tweets = []
    while(True):
        try:
            max_id = dao.get_oldest_tweetid()
            auth = tweepy.auth.AppAuthHandler(twitter_setting.consumer_key, twitter_setting.consumer_secret)
            #auth.set_access_token(twitter_setting.access_token, twitter_setting.access_secret)
            api = tweepy.API(auth)
            tweets = api.user_timeline(
                        screen_name = app_setting.target_user_id,
                        count = app_setting.daily_get_count,
                        max_id = int(max_id))
        except tweepy.error.TweepError as e:
            print("tweepy error:%s" % e.reason)
            exit()
        print("get tweet %d count" % len(tweets))
        
        if(len(tweets) == 0):
            break

        for tweet in tweets:
            is_boron = 1 if tweet.text == "チンポ（ﾎﾞﾛﾝ" else 0
            text = tweet.text
            print(text)
            tweet_id = tweet.id_str
            created_at = tweet.created_at
            try:
                dao.insert(
        """
        insert into daily (is_boron, tweet, tweet_id, date)
        values (%s, %s, %s, %s)
        """,
                    (is_boron, text, tweet_id, created_at)
                )
            except mysql.connector.Error as e:
                print(e)
        
    print("-- done! --")