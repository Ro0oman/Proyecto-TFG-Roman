<template>
  <page-component
    title="PC-Builder">
      <div class="w-full h-80">
        <n-carousel show-arrow autoplay>
          <router-link :to="{ name: 'Application' }">
            <img
              class="carousel-img"
              src="../assets/4000series.jpg"
            >
          </router-link>
          <router-link :to="{ name: 'Community' }">
            <img
              class="carousel-img"
              src="../assets/community.png"
            >
          </router-link>
          <router-link :to="{ name: 'Application' }">
            <img
              class="carousel-img"
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
      </div>
    </page-component>
</template>

<script>
import { NCarousel,NIcon } from 'naive-ui';
import { ArrowBack, ArrowForward,  } from "@vicons/ionicons5";
import PageComponent from '../components/PageComponent.vue'

export default {
  components: { 
    PageComponent,
    NCarousel,
    ArrowBack,
    ArrowForward,
    NIcon
  },

}
</script>

<style>

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