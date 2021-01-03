
(define atom?
  (lambda (x)
    (and (not (pair? x)) (not (null? x))
    )
  )
)

(define lat?
  (lambda (l)
    (cond
	((null? l) #t)
	((atom? (car l)) (lat? (cdr l)))
	(else #f)
    )
  )
)

(define member?
  (lambda (a lat)
    (cond
      ((null? lat) #f)
      (else (or (eq? (car lat) a) 
                (member? a (cdr lat))
            )
      )
    )
  )
)

(define rember
  (lambda (a lat)
    (cond
      ((null? lat) (quote ()))
      ((eq? (car lat) a) (cdr lat))
      (else (cons (car lat) (rember a (cdr lat))))
    )
  )
)

(define firsts
  (lambda (l)
    (cond
      ((null? l) (quote ()))
      (else (cons (car (car l)) 
                  (firsts (cdr l))
            )
      )
    )
  )
)

(define insertR
  (lambda (adda pat lat)
    (cond
      ((null? lat) (quote ()))
      (else (cond
              ((eq? (car lat) pat) (cons pat (cons adda (cdr lat))))
              (else (cons (car lat) (insertR adda pat (cdr lat))))
            )
      )
    )
  )
)

(define insertL
  (lambda (adda pat lat)
    (cond
      ((null? lat) (quote ()))
      (else (cond
              ((eq? (car lat) pat) (cons adda (cons pat (cdr lat))))
              (else (cons (car lat) (insertL adda pat (cdr lat))))
            )
      )
    )
  )
)

(define add1
  (lambda (n)
    (+ n 1)))

(define sub1
  (lambda (n)
    (- n 1)))

; --- Checkt als de atom gelijk is aan true of false en returned de juiste waarde ---
(define isWhat
  (lambda (a)
    (cond
      ((eq? a 'true) #t)
      (else (eq? a 'false) #f)
      )))

; --- Converts a true into a false and a false into a true ---
              
(define evalbool
  (lambda (l)
    (cond
      ((null? l))
      (else (cond
              ((atom? l) (isWhat l))
              (else (cond
                                ((eq? (car l) 'or)
                                 (or  (evalbool (car (cdr l))) (evalbool (car (cddr l)))) )
                                ((eq? (car l) 'and)
                                 (and (evalbool (car (cdr l))) (evalbool (car (cddr l)))) )
                                (else (not (evalbool (car (cdr l)))))
                    )
              ))))))
  

; --- (isWhat 'true) ---
; --- (isWhat 'false) ---
; --- (not (isWhat 'true)) ---
; --- (not (isWhat 'false)) ---
; --- (evalbool 'true) ---
; --- (evalbool 'false) ---

; --- (evalbool '(not true)) ---
; --- (evalbool '(not false)) ---
; --- (evalbool '(not (not (not true)))) ---
(evalbool '(and (not true) false))
(evalbool '(and (not true) (or false true)))
(evalbool '(or (not true) (or false true)))
(or #t #f)
