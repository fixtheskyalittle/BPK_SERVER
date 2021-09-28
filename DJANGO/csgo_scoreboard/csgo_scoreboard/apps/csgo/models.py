from django.db import models
import datetime
from django.utils import timezone

class user(models.Model):
	login = models.CharField('login', max_length=32)
	email = models.CharField('email', max_length=32)
	password = models.CharField('Password', max_length=128)
	status = models.IntegerField('Status')
	def __str__(self):
		return self.login

	class Meta:
		verbose_name = 'Пользователь'
		verbose_name_plural = 'Пользователи'

class match(models.Model):
	comand_1 = models.CharField('Comand1', max_length=32)
	comand_2 = models.CharField('Comand2', max_length=32)
	img1 = models.CharField('Image', max_length=128, default="test")
	img2 = models.CharField('Image', max_length=128, default="test")
	date_update = models.DateTimeField('Date Update', default=datetime.datetime.now())
	match_key = models.IntegerField('match_key')
	score_1 = models.IntegerField('Score 1', default="0")
	score_2 = models.IntegerField('Score 2', default="0")
	status = models.IntegerField('Status')
	def __str__(self):
		return self.comand_1 + " | " + self.comand_2

	class Meta:
		verbose_name = 'Матч'
		verbose_name_plural = 'Матчи'

class league(models.Model):
	league = models.CharField('League', max_length=32)
	status = models.IntegerField('Status')
	def __str__(self):
		return self.league

	class Meta:
		verbose_name = 'Лига'
		verbose_name_plural = 'Отключенные Лиги'

class proxy(models.Model):
	ip = models.CharField('IP', max_length=64)
	port = models.CharField('PORT', max_length=16)
	status = models.IntegerField('Status')
	def __str__(self):
		return self.ip + ":" + self.port

	class Meta:
		verbose_name = 'Прокси'
		verbose_name_plural = 'Прокси'