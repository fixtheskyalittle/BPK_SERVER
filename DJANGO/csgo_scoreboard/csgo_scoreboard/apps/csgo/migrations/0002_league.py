# Generated by Django 3.2.6 on 2021-08-26 22:21

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('csgo', '0001_initial'),
    ]

    operations = [
        migrations.CreateModel(
            name='league',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('league', models.CharField(max_length=32, verbose_name='League')),
                ('status', models.IntegerField(verbose_name='Status')),
            ],
            options={
                'verbose_name': 'Лига',
                'verbose_name_plural': 'Доступные Лиги',
            },
        ),
    ]
