import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FeedbackTrackingComponent } from './feedback-tracking.component';

describe('FeedbackTrackingComponent', () => {
  let component: FeedbackTrackingComponent;
  let fixture: ComponentFixture<FeedbackTrackingComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FeedbackTrackingComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(FeedbackTrackingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
