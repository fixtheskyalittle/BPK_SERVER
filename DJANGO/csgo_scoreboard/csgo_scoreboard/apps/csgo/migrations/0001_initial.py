# Generated by Django 3.2.6 on 2021-08-23 12:46

from django.db import migrations, models


class Migration(migrations.Migration):

    initial = True

    dependencies = [
    ]

    operations = [
        migrations.CreateModel(
            name='match',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('comand_1', models.CharField(max_length=32, verbose_name='Comand1')),
                ('comand_2', models.CharField(max_length=32, verbose_name='Comand2')),
                ('img1', models.CharField(max_length=128, verbose_name='Image')),
                ('img2', models.CharField(max_length=128, verbose_name='Image')),
                ('date_update', models.DateTimeField(verbose_name='Date Update')),
                ('match_key', models.IntegerField(verbose_name='match_key')),
                ('score_1', models.IntegerField(verbose_name='Score 1')),
                ('score_2', models.IntegerField(verbose_name='Score 2')),
                ('status', models.IntegerField(verbose_name='Status')),
            ],
            options={
                'verbose_name': 'Матч',
                'verbose_name_plural': 'Матчи',
            },
        ),
    ]
