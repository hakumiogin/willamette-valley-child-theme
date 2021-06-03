/* eslint-disable */
import { navigationInit } from "./navigation"
import AOS from 'aos';
import { slideShow } from "./slideshow"

navigationInit()
AOS.init();
slideShow();