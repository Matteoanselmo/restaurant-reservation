<script setup>
import { ref } from "vue";
import { useI18n } from "vue-i18n";

const { locale } = useI18n();

function setLocale(lang) {
    locale.value = lang;
}

function showDetails() {
    document.querySelector(".list-container").classList.toggle("active");
}
</script>
<template>
    <div class="list-container">
        <button
            class="more-button"
            aria-label="Menu Button"
            @click="showDetails"
        >
            <i class="fa-solid fa-bars"></i>
        </button>
        <ul class="more-button-list">
            <li class="more-button-list-item">
                <div class="d-flex">
                    <p class="m-0">
                        Villa Albertina HR - Simone FInetti - P.Iva: 012345678 -
                        Via Pozze Androna 16, 44011, Boccaleone (FE)
                    </p>
                </div>
            </li>
            <li class="more-button-list-item">
                <a
                    :href="route('about')"
                    class="text-decoration-none text-black"
                >
                    <i class="fa-solid fa-kitchen-set"></i>
                    {{ $t("commons.who-we-are") }}
                </a>
            </li>
            <li class="more-button-list-item">
                <a
                    href="mailto:info.villaalbertina@gmail.com"
                    class="text-decoration-none text-black"
                >
                    <i class="fa-regular fa-envelope"></i>
                    info.villaalbertina@gmail.com
                </a>
            </li>
            <li class="more-button-list-item">
                <div class="dropdown">
                    <button
                        class="btn btn-secondary dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        {{ $t("commons.language") }}
                    </button>
                    <ul class="dropdown-menu bg-white">
                        <li
                            class="more-button-list-item"
                            @click="setLocale('it')"
                        >
                            <span>It</span>
                        </li>
                        <li
                            class="more-button-list-item"
                            @click="setLocale('en')"
                        >
                            <span>En</span>
                        </li>
                        <li
                            class="more-button-list-item"
                            @click="setLocale('fr')"
                        >
                            <span>Fr</span>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</template>

<style lang="scss" scoped>
@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(128, 128, 128, 0.8);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(128, 128, 128, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(128, 128, 128, 0);
    }
}

* {
    box-sizing: border-box;
}

$list-bg: #fff;
$menu-icon-transition: transform 0.3s;

.list-container {
    position: relative;

    &.active {
        .more-button-list {
            opacity: 1;
            z-index: 3;
            transform: scale(1);
            pointer-events: auto;
        }

        .more-button-list-item {
            animation: fadeInItem 0.6s 0.2s forwards;
            &:hover {
                background-color: rgb(232, 232, 232);
                border-radius: 6px;
                span {
                    transform: translateX(3px) scale(1.115);
                    transition: all 0.25s ease-in-out;
                }
            }
            &:nth-child(2) {
                animation-delay: 0.4s;
            }
            &:nth-child(3) {
                animation-delay: 0.6s;
            }
            &:nth-child(4) {
                animation-delay: 0.8s;
            }
        }

        .more-button {
            animation: pulse 0.6s forwards linear;
        }

        .menu-icon-wrapper {
            transform: rotate(-45deg);
        }

        .menu-icon-line {
            &.first {
                transform: rotate(-90deg) translateX(1px);
            }

            &.last {
                transform: rotate(-90deg) translateX(-1px);
            }
        }
    }
}

.more-button {
    position: fixed;
    bottom: 10px;
    left: 15px;
    background-color: white;
    border: none;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    animation: pulse 2s infinite;
    z-index: 1000;

    &-list {
        animation: pulse 2s infinite;
        background-color: white;
        border-radius: 8px;
        list-style-type: none;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        padding: 0;
        padding: 6px;
        width: 75vw;
        position: fixed;
        left: 50%;
        transform: translate(-50%) !important;
        bottom: 0;
        opacity: 0;
        transform: scale(0);
        transform-origin: bottom left;
        transition: all 0.3s ease 0.1s;
        pointer-events: none;
        li {
            opacity: 0;
        }
    }

    &-list-item {
        display: flex;
        align-items: center;
        color: black;
        padding: 10px;
        border-radius: 4px;
        cursor: pointer;
        position: relative;
        transition: 0.2s ease-in;
        transform: translatex(-10px);

        &:after {
            content: "";
            position: absolute;
            height: 1px;
            width: calc(100% - 24px);
            left: 12px;
            bottom: 0;
            background-color: rgba(132, 160, 244, 0.1);
        }
        &:last-child:after {
            display: none;
        }

        svg {
            width: 18px;
            height: 18px;
        }

        span {
            display: inline-block;
            line-height: 20px;
            font-size: 14px;
            margin-left: 8px;
        }
    }
}

@keyframes fadeInItem {
    100% {
        transform: translatex(0px);
        opacity: 1;
    }
}

.menu-icon-wrapper {
    border-radius: 2px;
    width: 20px;
    height: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    cursor: pointer;
    transition: transform 330ms ease-out;
}

.menu-icon-line {
    background-color: #fff;
    border-radius: 2px;
    width: 100%;
    height: 2px;

    &.half {
        width: 50%;
    }

    &.first {
        transition: $menu-icon-transition;
        transform-origin: right;
    }

    &.last {
        align-self: flex-end;
        transition: $menu-icon-transition;
        transform-origin: left;
    }
}
</style>
