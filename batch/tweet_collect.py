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
    import sys
    from argparse import ArgumentParser

    parser = ArgumentParser(description="Get tweets from The Doraemon and save to database.")
    parser.add_argument('-n', action="store_true" , help = 'get the newly tweets.(default)')
    parser.add_argument('-o', action="store_true", help = 'get tweets going back to the past.')
    parser.add_argument('count', action='store', nargs=None , type=int)

    args = parser.parse_args()

    rest_count = args.count # 取得件数
    mode_update = args.n # 新しいツイートを取得
    mode_old = args.o # 古いツイートを遡って取得

    dao = Dao()
    tweets = []
    while(rest_count > 0):
        try:
            opt_arg = {}
            get_count = 200 if rest_count > 200 else rest_count
            rest_count -= get_count
            if mode_update or (not mode_update and not mode_old):
                since_id = dao.get_last_tweetid()
                if since_id != None:
                    opt_arg = {"since_id": since_id}
                    print( "last get tweet id:%d" % since_id)
            else:
                max_id = dao.get_oldest_tweetid()
                if max_id != None:
                    opt_arg = {"max_id": max_id}
                    print( "got oldest tweet id:%d" % max_id)
            # application only authontication
            auth = tweepy.auth.AppAuthHandler(twitter_setting.consumer_key, twitter_setting.consumer_secret)
            api = tweepy.API(auth)
            tweets = api.user_timeline(
                        screen_name = app_setting.target_user_id,
                        count = get_count,
                        **opt_arg)
        except tweepy.error.TweepError as e:
            print("tweepy error:%s" % e.reason)
            exit()
        print("get tweet %d count" % len(tweets))

        for tweet in tweets:
            is_boron = 1 if tweet.text == "チンポ（ﾎﾞﾛﾝ" else 0
            text = tweet.text
            print(text)
            tweet_id = tweet.id_str
            created_at = tweet.created_at
            try:
                dao.insert("""
                    insert into daily (is_boron, tweet, tweet_id, date)
                    values (%s, %s, %s, %s)""",
                    (is_boron, text, tweet_id, created_at))
            except mysql.connector.Error as e:
                print(e)
                        
        if(len(tweets) == 1):
            break
        
    print("-- done! --")