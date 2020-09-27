(define suffixes
  (lambda (x)
    (cond
      ((null? x) '(()))
      (else (cons x (suffixes (cdr x))))
      )))