import { TestBed } from '@angular/core/testing';

import { CreateaccountService } from './createaccount.service';

describe('CreateaccountService', () => {
  let service: CreateaccountService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CreateaccountService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
