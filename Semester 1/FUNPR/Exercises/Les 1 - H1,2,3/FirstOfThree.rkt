(define FirstOfThree
  (lambda (x y z)
    (cond
      ((or (null? x) (or (null? y) (null? z))) #f)
      (else (cons (car x) (cons (car y) (cons (car z) '() ))))
            )))