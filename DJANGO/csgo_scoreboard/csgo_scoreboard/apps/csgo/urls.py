from django.urls import path

from . import views


urlpatterns = [
	path('cron/', views.main, name="main"),
	path('data/<str:matchid>/', views.ajax, name="ajax"),
	path('data/', views.ajax_all, name="ajax_all")
]