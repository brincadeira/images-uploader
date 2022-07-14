Разработать прототип хостинга изображений.

Инструменты для реализации задания:
- фреймворк Yii2 (обязательно)
- mysql

1. Реализовать форму для загрузки изображений.

При загрузке изображений должны соблюдаться следующие правила:
- в 1 запросе, в одной форме, можно загружать до 5 файлов
- название каждого файла должно транслителироваться на английский язык и приводиться к нижнему регистру
- название каждого файла должно быть уникальным, и, если файл с таким названием существует, нужно задавать новому файлу уникальное название
- все файлы должны отправляться в одну директорию
- записывать в БД инфу о загруженных файлах: название файла, дата и время загрузки

2. Реализовать страницу просмотра информации об изображениях.

На странице должны быть реализованы:
- вывод информации о загруженных файлах (название файла, дата и время загрузки)
- просмотр превью изображения
- возможность просмотра оригинального изображения
- сортировка по названию/дате и времени загрузки изображения