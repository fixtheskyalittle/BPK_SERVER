from django.contrib import admin
from .models import match, league, user, proxy

admin.site.register(match)
admin.site.register(league)
admin.site.register(user)
admin.site.register(proxy)