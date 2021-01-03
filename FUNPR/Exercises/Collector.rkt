(define col
  (lambda (i list)
    list
    ))

;(define positions
;  (lambda (pattern l col)
;    (cond
;      ((null? l) (col '()))
;      ((eq? pattern (car l))
;       (positions pattern (cdr l)
;                  (lambda (indeces)
;                    (col (cons (length l) indeces)))))
;      (else
;       (positions pattern (cdr l) col)
;       ))))

;(positions 'a '(a b c d a c) col)

(define substodd*
  (lambda (p c l col)
    (cond
      ((null? l) (col '()))
      ((and (eq? p (car l)) (even? i))
       (substodd* p (cdr l)
                  (lambda (i list)
                  (cons c (col (+ i 1) list)))
                  ))
      ((eq? p (car l))
       (substodd* p (cdr l)
                  (lambda (i list)
                  (cons p (col (+ i 1) list)))
                  ))
      (else
       (substodd* p (cdr l)
                  (lambda (i list)
                  (cons (car l) (col i list)))
                  ))
      )))

(substodd* 'a 'z '(a b c a b c a) col)