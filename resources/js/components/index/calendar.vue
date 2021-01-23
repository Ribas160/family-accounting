<template>
    <vue-slick-carousel class="calendar" v-bind="settings">
        <div class="day" v-for="day in days">
            <span>{{ day }}</span>
        </div>
    </vue-slick-carousel>
</template>
<script>
    import VueSlickCarousel from 'vue-slick-carousel';
    import 'vue-slick-carousel/dist/vue-slick-carousel.css'
    import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'
    export default {
        components: {
            VueSlickCarousel,
        },
        data() {
            return {
                settings: {
                    infinite: false,
                    arrows: false,
                    rtl: true,
                    swipeToSlide: true,
                },
                days: getMonths(),
            }
        },
        mounted() {
            calendarWidth();
        }
    }

    // Получения массива дат начиная с 1970 года
    function getDates(startDate, stopDate) {
        let dateArray = [];
        let currentDate = startDate;
        while (currentDate <= stopDate) {
            dateArray.push(new Date (currentDate).toLocaleDateString().replace(/\./g, '-'));
            currentDate.setDate(currentDate.getDate() + 1);
        }
        return dateArray;
    }

    function getMonths() {
        let months = [
            'Январь',
            'Февраль',
            'Март',
            'Апрель',
            'Март',
            'Июнь',
            'Июль',
            'Август',
            'Сентябрь',
            'Октябрь',
            'Ноябрь',
            'Декабрь',
        ];
        let date = new Date();
        let arr = [];
        for (let i = 0; i < 10; i++) {
            arr.push(months[date.getMonth()]);
            date.setMonth(date.getMonth() - 1);
        }
        return arr;
    }

    getMonths();

    // Установка блоку календаря необходимой ширины
    function calendarWidth() {
        let calendar = document.querySelector('.calendar');
        let day = document.querySelectorAll('.day span');

        let dayMaxWidth = function () {
            let maxWidth = 0;
            day.forEach(el => {
                 if (el.offsetWidth > maxWidth) maxWidth = el.offsetWidth;
            });

            return maxWidth;
        }
        calendar.style.width = dayMaxWidth() + 'px';
    }
    window.onresize = () => {
        calendarWidth();
    }
</script>
<style scoped>
    .calendar {
        position: relative;
        margin: 0 auto;
        font-size: 4.5vw;
    }
    .calendar::after {
        content: '';
        position: absolute;
        width: 100%;
        left: 0;
        bottom: -10px;
        height: 2px;
        background: red;
    }

    .day {
        text-align: center;
    }

    .day span {
        width: max-content;
        padding: 0 0.5em;
        display: inline-block;
        text-align: center;
    }
</style>
<style>
    .calendar .slick-list {
        overflow: visible;
    }
</style>
