import { TestBed } from '@angular/core/testing';

import { GetUserReservationService } from './get-user-reservation.service';

describe('GetUserReservationService', () => {
  let service: GetUserReservationService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(GetUserReservationService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
