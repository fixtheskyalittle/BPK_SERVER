# Generated by Django 3.2.6 on 2021-08-27 16:18

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('csgo', '0003_user'),
    ]

    operations = [
        migrations.AlterField(
            model_name='user',
            name='password',
            field=models.CharField(max_length=128, verbose_name='Password'),
        ),
    ]