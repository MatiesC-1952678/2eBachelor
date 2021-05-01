#ifndef BARREL_H
#define BARREL_H


class Barrel
{
public:
    enum BARRELTYPE { NORMAL, FIREBARREL, EXPLOSIVE };
private:
    BARRELTYPE type;
public:
    Barrel();
};

#endif // BARREL_H
