import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FullscreenBackgroundComponent } from './fullscreen-background.component';

describe('FullscreenBackgroundComponent', () => {
  let component: FullscreenBackgroundComponent;
  let fixture: ComponentFixture<FullscreenBackgroundComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FullscreenBackgroundComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(FullscreenBackgroundComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
