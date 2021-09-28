from django.shortcuts import render
from django.http import Http404, HttpResponseRedirect
from django.http import HttpResponse
from bs4 import BeautifulSoup
import json
from .models import match, proxy, league
import datetime
from django.utils.timezone import utc
import requests
import json
import os
import re
import time
import random

headers = {
    'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 11_5_2) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.2 Safari/605.1.15'
}
league_brok = []
def from_steam64(sid):
    y = int(sid) - 76561197960265728
    #print(y)
    return str(y)

#options = webdriver.ChromeOptions()
#options.add_argument('--headless')
def get_proxy():
	proxy = proxy.objects.all()
	data_return = random.choice(proxy)
	return data_return.ip + ":" + data_return.port

def analysis(url):
	time.sleep(10)
	response = requests.get("https://liquipedia.net" + url, headers=headers)
	soup = BeautifulSoup(response.text, 'lxml')
	try:
		table = soup.find_all('div', class_="table-responsive")[0]
	except IndexError:
		print("err-index")
		return "none"
	data = table.find('tbody').find_all('tr')
	for player in data:
		if player.find('td') == None:
			continue
		if player.find_all('td')[1].find('a') == None:
			continue
		else:
			time.sleep(10)
			response = requests.get("https://liquipedia.net" + player.find_all('td')[1].find('a').get("href"), headers=headers)
			soup = BeautifulSoup(response.text, 'lxml')

			table = soup.find('div', class_="infobox-center infobox-icons")
			if (table == None):
				continue
			if (table.find_all('a')[-1].find('i', class_="lp-icon lp-steam") != None):
				if table.find_all('a')[-1].get("href") == "":
					continue
				else:
					if (len(get_stat(from_steam64(table.find_all('a')[-1].get("href").split("/")[4])).split(":")) < 2):
						continue
					else:
						return from_steam64(table.find_all('a')[-1].get("href").split("/")[4])
			else:
				continue
	return "none"

def search_for_name():
	time.sleep(10)
	data_json = ""
	pars_data = ""
	i = 0
	url = "https://liquipedia.net/counterstrike/Main_Page"
	response = requests.get(url, headers=headers)
	soup = BeautifulSoup(response.text, 'lxml')
	matches = soup.find('div', class_='panel-box wiki-bordercolor-light toggle-area toggle-area-1 matches-list')
	for match in matches.find_all('table', class_="wikitable wikitable-striped infobox_matches_content"):
		try:
			print(match.find_all('span', class_="team-template-text")[0].find('a').text + ":" + match.find_all('span', class_="team-template-text")[1].find('a').text)
			if match.find('td', class_='versus').text.find(':') == -1:
				break
			else:
				err_bad = False
				for leag in league_brok:
					if (match.find('td', class_='match-filler').find_all('a')[0].text).find(leag) != -1:
						err_bad = True
						break
				if err_bad:
					continue
				if ('(page does not exist)' in str(match.find_all('span', class_="team-template-text")[0].find("a").get("title"))) == False:
					analys = analysis(match.find_all('span', class_="team-template-text")[0].find('a').get("href"))
					if (analys != "none"):
						if len(get_stat(analys).split(":")) < 2:
							pars_data = pars_data + ""
						else:
							try:
								if pars_data == "":
									pars_data = pars_data + '{"comand1":"'+match.find_all('span', class_="team-template-text")[0].find('a').text+'", "img1":"'+match.find_all('span', class_="team-template-image-icon")[0].find('a').find('img').get('src')+'", "img2":"'+match.find_all('span', class_="team-template-image-icon")[2].find('a').find('img').get('src')+'", "match_key":"'+analys+'", "comand2":"'+match.find_all('span', class_="team-template-text")[1].find('a').text+'", "score1": "0", "score2": "0"}'
								else:
									pars_data = pars_data + ',{"comand1":"'+match.find_all('span', class_="team-template-text")[0].find('a').text+'", "img1":"'+match.find_all('span', class_="team-template-image-icon")[0].find('a').find('img').get('src')+'", "img2":"'+match.find_all('span', class_="team-template-image-icon")[2].find('a').find('img').get('src')+'", "match_key":"'+analys+'", "comand2":"'+match.find_all('span', class_="team-template-text")[1].find('a').text+'", "score1": "0", "score2": "0"}'
							except IndexError:
								continue
							i+=1
					else:
						analys = analysis(match.find_all('span', class_="team-template-text")[1].find('a').get("href"))
						if (analys != "none"):
							if len(get_stat(analys).split(":")) < 2:
								pars_data = pars_data + ""
							else:
								try:
									if pars_data == "":
										comand1 = match.find_all('span', class_="team-template-text")[0].find('a').text
										comand2 = match.find_all('span', class_="team-template-text")[1].find('a').text
										img = match.find_all('span', class_="team-template-image-icon")[0].find('a').find('img').get('src')
										img2 = match.find_all('span', class_="team-template-image-icon")[2].find('a').find('img').get('src')
										pars_data = pars_data + '{"comand1":"'+match.find_all('span', class_="team-template-text")[0].find('a').text+'", "img1":"'+match.find_all('span', class_="team-template-image-icon")[0].find('a').find('img').get('src')+'", "img2":"'+match.find_all('span', class_="team-template-image-icon")[2].find('a').find('img').get('src')+'", "match_key":"'+analys+'", "comand2":"'+match.find_all('span', class_="team-template-text")[1].find('a').text+'", "score1": "0", "score2": "0"}'
									else:
										pars_data = pars_data + ',{"comand1":"'+match.find_all('span', class_="team-template-text")[0].find('a').text+'", "img1":"'+match.find_all('span', class_="team-template-image-icon")[0].find('a').find('img').get('src')+'", "img2":"'+match.find_all('span', class_="team-template-image-icon")[2].find('a').find('img').get('src')+'", "match_key":"'+analys+'", "comand2":"'+match.find_all('span', class_="team-template-text")[1].find('a').text+'", "score1": "0", "score2": "0"}'
								except IndexError:
									continue
								i+=1
						else:
							print("None data: end1")
							continue
				else:
					analys = analysis(match.find_all('span', class_="team-template-text")[1].find('a').get("href"))
					if (analys != "none"):
						if len(get_stat(analys).split(":")) < 2:
							pars_data = pars_data + ""
						else:
							if pars_data == "":
								pars_data = pars_data + '{"comand1":"'+match.find_all('span', class_="team-template-text")[0].find('a').text+'", "img1":"'+match.find_all('span', class_="team-template-image-icon")[0].find('a').find('img').get('src')+'", "img2":"'+match.find_all('span', class_="team-template-image-icon")[2].find('a').find('img').get('src')+'", "match_key":"'+analys+'", "comand2":"'+match.find_all('span', class_="team-template-text")[1].find('a').text+'", "score1": "0", "score2": "0"}'
							else:
								try:
									pars_data = pars_data + ',{"comand1":"'+match.find_all('span', class_="team-template-text")[0].find('a').text+'", "img1":"'+match.find_all('span', class_="team-template-image-icon")[0].find('a').find('img').get('src')+'", "img2":"'+match.find_all('span', class_="team-template-image-icon")[2].find('a').find('img').get('src')+'", "match_key":"'+analys+'", "comand2":"'+match.find_all('span', class_="team-template-text")[1].find('a').text+'", "score1": "0", "score2": "0"}'
								except IndexError:
									pars_data = pars_data + ',{"comand1":"'+match.find_all('span', class_="team-template-text")[0].find('a').text+'", "img1":"'+match.find_all('span', class_="team-template-image-icon")[0].find('a').find('img').get('src')+'", "img2":"'+match.find_all('span', class_="team-template-image-icon")[2].find('a').find('img').get('src')+'", "match_key":"'+analys+'", "comand2":"'+match.find_all('span', class_="team-template-text")[1].find('a').text+'", "score1": "0", "score2": "0"}'
						i+=1
					else:
						try:
							if match.find_all('span', class_="team-template-text")[1].find('a').get("href").find("redlink=1") != -1:
								continue
						except Exception:
							continue
						analys = analysis(match.find_all('span', class_="team-template-text")[1].find('a').get("href"))
						if (analys != "none"):
							if len(get_stat(analys).split(":")) < 2:
								pars_data = pars_data + ""
							else:
								if pars_data == "":
									pars_data = pars_data + '{"comand1":"'+match.find_all('span', class_="team-template-text")[0].find('a').text+'", "img1":"'+match.find_all('span', class_="team-template-image-icon")[0].find('a').find('img').get('src')+'", "img2":"'+match.find_all('span', class_="team-template-image-icon")[2].find('a').find('img').get('src')+'", "match_key":"'+analys+'", "comand2":"'+match.find_all('span', class_="team-template-text")[1].find('a').text+'", "score1": "0", "score2": "0"}'
								else:
									pars_data = pars_data + ',{"comand1":"'+match.find_all('span', class_="team-template-text")[0].find('a').text+'", "img1":"'+match.find_all('span', class_="team-template-image-icon")[0].find('a').find('img').get('src')+'", "img2":"'+match.find_all('span', class_="team-template-image-icon")[2].find('a').find('img').get('src')+'", "match_key":"'+analys+'", "comand2":"'+match.find_all('span', class_="team-template-text")[1].find('a').text+'", "score1": "0", "score2": "0"}'
								i+=1
						else:
							print("None data: end2")
							continue
							#return "none"
		except AttributeError:
			continue
	return '{"status":"ok", "tours": ['+ pars_data +']}'

def get_stat(account_id, field_match = False):
	player = ""
	url = 'https://steamcommunity.com/miniprofile/'+account_id+'.html'
	 
	# Use the object above to connect to needed webpage
	 
	# Run JavaScript code on webpage


	response = requests.get(url, headers=headers)
	soup = BeautifulSoup(response.text, 'lxml')
	live = soup.find('div', class_='miniprofile_container')

	try:
		if field_match == False:
			return re.sub(r'[^0-9:]+', r'', live.find('span', class_='rich_presence').text)
		else:
			return re.sub(re.sub(r'[^0-9:]+', r'', live.find('span', class_='rich_presence').text), '', live.find('span', class_='rich_presence').text)
	except AttributeError:
		print("AttributeError: end id: " + account_id)
		return "none"


def main(request):
	league_brok = []
	for legs in league.objects.all():
		league_brok.append(legs.league)
	print(league_brok)
	data = search_for_name()
	if (data != "none"):
		data_json = json.loads(data)
		gts = match.objects.all()
		if len(data_json['tours']) >= 1:
			match.objects.filter(status=1).all().delete()
			#gts.delete()
		if gts.exists():
		 	last_date = gts[0].date_update
		 	res_date = datetime.datetime.utcnow().replace(tzinfo=utc) - gts[0].date_update
		 	if res_date.seconds > 150:
		 		#match.objects.all().delete()
		 		match.objects.filter(status=1).all().delete()
		for matches in data_json['tours']:
			if (match.objects.filter(match_key=matches['match_key']).exists()):
				continue
			usr = match(comand_1=matches['comand1'], comand_2=matches['comand2'], img1=matches['img1'], date_update=datetime.datetime.now(), img2=matches['img2'], match_key=matches['match_key'], score_1=0, score_2=0, status=1)
			usr.save()
		return HttpResponse("ok")
	else:
		return HttpResponse("none")

def ajax(request, matchid):
	#try:
	gt = match.objects.get(match_key=matchid)
	if gt != None:
			mtch = get_stat(matchid)
			#if any(map(str.isdigit, get_stat(matchid))):
			try:
				return HttpResponse( '{"comand_1":"'+gt.comand_1+'", "img1":"'+gt.img1+'", "img2":"'+gt.img2+'", "match_key":"'+str(gt.match_key)+'", "comand2":"'+gt.comand_2+'", "score1": "'+mtch.split(":")[0]+'", "score2": "'+mtch.split(":")[1]+'", "map_name": "'+get_stat(matchid, True)+'"}')
			except IndexError:
				return HttpResponse( '{"comand_1":"'+gt.comand_1+'", "img1":"'+gt.img1+'", "img2":"'+gt.img2+'", "match_key":"'+str(gt.match_key)+'", "comand2":"'+gt.comand_2+'", "score1": "Wait", "score2": "Wait", "map_name": "'+get_stat(matchid, True)+'"}')
			#else:
			#	return HttpResponse( '{"comand_1":"'+gt.comand_1+'", "img1":"'+gt.img1+'", "img2":"'+gt.img2+'", "match_key":"'+str(gt.match_key)+'", "comand2":"'+gt.comand_2+'", "score1": "0", "score2": "0", "map_name": "'+get_stat(matchid, True)+'"}')
	else:
		return HttpResponse( '{"status": "none1"}')
	#except Exception as t:
	#	return HttpResponse( '{"status": "none2"}')


def ajax_all(request):
	gts = match.objects.all()
	pars_data = ""
	if gts != None:
		for gt in gts:
			if pars_data == "":
				pars_data = pars_data + '{"comand_1":"'+gt.comand_1+'", "img1":"'+gt.img1+'", "img2":"'+gt.img2+'", "match_key":"'+str(gt.match_key)+'", "comand_2":"'+gt.comand_2+'", "score1": "0", "score2": "0"}'
			else:
				pars_data = pars_data + ',{"comand_1":"'+gt.comand_1+'", "img1":"'+gt.img1+'", "img2":"'+gt.img2+'", "match_key":"'+str(gt.match_key)+'", "comand_2":"'+gt.comand_2+'", "score1": "0", "score2": "0"}'
		return HttpResponse( '{"status":"ok", "tours": ['+ pars_data +']}')
	else:
		return HttpResponse( '{"status": "none"}')