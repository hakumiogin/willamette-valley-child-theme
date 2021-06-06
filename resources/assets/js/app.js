/* eslint-disable */
import { navigationInit } from "./navigation"
import AOS from 'aos';
import { slideShow } from "./slideshow"
import { layout } from "./layout"
navigationInit()
AOS.init();
slideShow();
layout();