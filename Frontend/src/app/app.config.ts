
// @ts-ignore
import { ApplicationConfig, provideZoneChangeDetection } from '@angular/core';
import { provideHttpClient } from '@angular/common/http';
import { routes } from './app.routes';
import {provideRouter} from "@angular/router";
export const appConfig: ApplicationConfig = {
  providers: [provideZoneChangeDetection({ eventCoalescing: true }),provideRouter(routes), provideHttpClient()]
};
