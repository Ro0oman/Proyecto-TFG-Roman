<template>
  <page-component
    title="Main page">
      <div class=" max-w-6xl">
        <n-carousel show-arrow autoplay draggable loop>
          <router-link :to="{ name: 'Application' }">
            <img
              class="carousel-img object-fit"
              src="../assets/4000series.jpg"
            >
          </router-link>
          <router-link :to="{ name: 'Community' }">
            <img
              class="carousel-img object-fit"
              src="../assets/community.png"
            >
          </router-link>
          <router-link :to="{ name: 'Application' }">
            <img
              class="carousel-img object-fit"
              src="../assets/games.png"
            >
          </router-link>
          <template #arrow="{ prev, next }">
            <div class="custom-arrow">
              <button type="button" class="custom-arrow--left" @click="prev">
                <n-icon><ArrowBack /></n-icon>
              </button>
              <button type="button" class="custom-arrow--right" @click="next">
                <n-icon><ArrowForward /></n-icon>
              </button>
            </div>
          </template>
          <template #dots="{ total, currentIndex, to }">
            <ul class="custom-dots">
              <li
                v-for="index of total"
                :key="index"
                :class="{ ['is-active']: currentIndex === index - 1 }"
                @click="to(index - 1)"
              />
            </ul>
          </template>
        </n-carousel>

        <div class="overflow-hidden customLightBlack sm:py-32 mt-10">
          <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 sm:gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-2">
              <div class="lg:pr-8 lg:pt-4">
                <div class="lg:max-w-lg">
                  <h2 class="text-base font-semibold leading-7 text-yellow-600">Create Faster</h2>
                  <p class="mt-2 text-3xl font-bold tracking-tight text-yellow-300 sm:text-4xl">What do we do?</p>
                  <p class="mt-6 text-lg leading-8 text-gray-600">
                    Our site is an online resource for people interested in building their <span>own PC</span>, whether it's for work, play, or just a hobby project. The page offers an intuitive application to <span>help users build their own PC from scratch</span>, as well as a section dedicated to <span>gamers</span> to help them optimize their PCs for specific games. There is also an online community where users can <span></span>. In short, our page is a comprehensive resource for all things PC building.
                  </p>
                  <dl class="mt-10 max-w-3xl space-y-8 text-base leading-7 text-gray-600 lg:max-w-none">
                    <div class="flex flex-row">
                      <div class="h-full m-auto">
                        <Icon>
                          <FootstepsOutline class="w-16 h-16 icon"/>
                        </Icon>
                      </div>
                      <div class="relative pl-9">
                        <dt class="inline font-semibold text-gray-900">
                          
                          <span>
                            Step-by-Step Constructions
                          </span>
                        </dt>
                        <dd class="inline">We provide detailed builds that guide you through every step of the PC building process. Even if you've never built a PC before, our tutorials make it easy and accessible. You'll gain the satisfaction of building your own custom PC and the confidence to tackle future projects..</dd>
                      </div>
                    </div>
                    <div class="flex flex-row">
                      <div class="h-full m-auto">
                        <Icon>
                          <GameControllerOutline class="w-16 h-16 icon"/>
                        </Icon>
                      </div>
                      <div class="relative pl-9">
                      <dt class="inline font-semibold text-gray-900">
                        <span>
                          Gaming Optimization
                        </span>
                      </dt>
                      <dd class="inline">For the gamers out there, our website offers a dedicated section with tips and tricks to optimize your PC for the best gaming experience. Whether you're playing the latest AAA titles or competitive esports, we've got you covered with recommendations for hardware and software tweaks.</dd>
                    </div>
                    </div>
                    <div class="flex flex-row">
                      <div class="h-full m-auto">
                        <Icon>
                          <People32Regular class="w-16 h-16 icon"/>
                        </Icon>
                      </div>
                      <div class="relative pl-9">
                      <dt class="inline font-semibold text-gray-900">
                        <span>
                          Community Showcase
                        </span>
                      </dt>
                      <dd class="inline">Share your custom PC build with our community! Our website allows users to showcase their builds and receive feedback from other PC builders. Connect with like-minded individuals and learn from the experiences of others to take your PC building skills to the next level.</dd>
                      </div>
                    </div>
                  </dl>
                </div>
              </div>
              <img src="../assets/pagina.png" alt="Product screenshot" class="w-[48rem] max-w-none rounded-xl shadow-xl ring-1 ring-gray-400/10 sm:w-[57rem] md:-ml-4 lg:-ml-0" width="2432" height="1442">
            </div>
          </div>
        </div>
        <hr>
        <div class="bg-[#262626] py-24 sm:py-32">
          <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <dl class="grid grid-cols-1 gap-x-8 gap-y-16 text-center lg:grid-cols-3">
              <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                <dt class="text-base leading-7 text-yellow-200">Easy to use design</dt>
                <dd class="order-first text-3xl font-semibold tracking-tight text-yellow-500 sm:text-5xl">Interactive</dd>
              </div>
              <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                <dt class="text-base leading-7 text-yellow-200">Access the page without paying</dt>
                <dd class="order-first text-3xl font-semibold tracking-tight text-yellow-500 sm:text-5xl">Completely free</dd>
              </div>
              <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                <dt class="text-base leading-7 text-yellow-200">Help to choose the best components</dt>
                <dd class="order-first text-3xl font-semibold tracking-tight text-yellow-500 sm:text-5xl">Educative</dd>
              </div>
            </dl>
          </div>
        </div>
      </div>
      
    </page-component>
</template>

<script>
import { NCarousel,NIcon } from 'naive-ui';
import { ArrowBack, ArrowForward, FootstepsOutline, GameControllerOutline, People } from "@vicons/ionicons5";
import { People32Regular } from "@vicons/fluent";

import PageComponent from '../components/PageComponent.vue'

export default {
  components: { 
    PageComponent,
    NCarousel,
    ArrowBack,
    ArrowForward,
    NIcon, FootstepsOutline,
    GameControllerOutline, People32Regular
  },

}
</script>

<style scoped>

span{
  color: yellow;
}

.carousel-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  cursor: pointer;
}

.custom-arrow {
  display: flex;
  position: absolute;
  bottom: 25px;
  right: 10px;
}

.custom-arrow button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 28px;
  height: 28px;
  margin-right: 12px;
  color: #000000;
  background-color: rgba(255, 255, 255, 1);
  border-width: 0;
  border-radius: 8px;
  transition: background-color 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  cursor: pointer;
}

.custom-arrow button:hover {
  background-color: rgba(106, 255, 0, 1);
}

.custom-arrow button:active {
  transform: scale(0.95);
  transform-origin: center;
}

.custom-dots {
  display: flex;
  margin: 0;
  padding: 0;
  position: absolute;
  bottom: 20px;
  left: 20px;
}

.custom-dots li {
  display: inline-block;
  width: 12px;
  height: 4px;
  margin: 0 3px;
  border-radius: 4px;
  background-color: rgba(162, 255, 0, 1);
  transition: width 0.3s, background-color 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  cursor: pointer;
}

.custom-dots li.is-active {
  width: 40px;
  background: #ff0000;
}
</style>